<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Google\Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AiSearchController extends Controller
{
    public function search(Request $request)
    {
        $userPrompt = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        // Menggunakan gemini-1.5-flash-latest (ini alias paling stabil saat ini)
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $apiKey;

        $context = "
        ROLE: 
        You are a PostgreSQL Expert specialized in Manufacturing Production Tracking.

        DATA DICTIONARY (Table: serial_number_data):
        - 'serial_number': Serial number from unique item.
        - 'bagian': Location code. 'SMG' = Semarang (3000), 'SBY' = Surabaya (2000).
        - 'status': Production stage. Valid values: 'ASSY', 'PAINTING', 'PACKING', 'BLEACHING'.
        - 'updated_at': Timestamp for last data synchronization.
        - 'so_item': Sales order-item code.
        - 'plant': Same as 'bagian', represents location code.
        - 'flag_inspection': Difference between GR confirm and inspection result.

        ---
        CRITICAL COLUMN MAPPING (HIGH PRIORITY):
        The columns for dates, materials, and operators are DYNAMIC based on the 'status'. 
        You MUST use the correct suffix:

        1. DATE COLUMNS (MUST MATCH STATUS):
        - If status = 'ASSY' -> Use 'posting_date_assy'
        - If status = 'PAINTING' -> Use 'posting_date_painting'
        - If status = 'PACKING' -> Use 'posting_date_packing'
        - If status = 'BLEACHING' -> Use 'posting_date_bleaching'
        *NEVER use a generic 'posting_date' column.*

        2. MATERIAL & PROCESS COLUMNS:
        - Pattern: [attribute]_[status]. 
        - Examples: 'material_assembly', 'material_painting', 'operator_packing', 'inspector_bleaching'.
        - This applies to: material, batch, storage, pro, mrp, material_doc, release_date, operator, inspector.
        ---

        STRICT QUERY RULES:
        1. LOCATION: 'Semarang' -> bagian = 'SMG'. 'Surabaya' -> bagian = 'SBY'.
        2. PROCESS SYNONYMS: 
        - 'packing'/'finishing' -> status = 'PACKING'.
        - 'assy'/'assembly' -> status = 'ASSY'.
        3. DATE FORMAT: Always 'YYYY-MM-DD'. Do NOT use TRY_CONVERT.
        4. SEARCH: Use ILIKE for partial serial number searches.
        5. OUTPUT: Return ONLY the raw SQL string. No markdown, no explanation.

        MANDATORY PRE-QUERY CHECKS:
        - If 'location' is missing, STOP and ask for confirmation.
        - If 'process' is missing, STOP and ask for confirmation.
        - If 'year' in date is missing, STOP and ask for confirmation.
        ";

        $response = Http::timeout(120)->withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => $apiKey, // Gunakan header ini sesuai curl tadi
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "Role: PostgreSQL Expert. \nContext: $context \nQuestion: " . $userPrompt]
                            ]
                        ]
                    ]
                ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Google API Error',
                'details' => $response->json()
            ], $response->status());
        }

        $sql = $response->json('candidates.0.content.parts.0.text');

        // Pastikan string SQL bersih
        $sql = trim(str_replace(['```sql', '```', "\n"], ' ', $sql));

        if (!str_starts_with(strtoupper($sql), 'SELECT')) {
            return response()->json([
                'status' => 'need_confirmation',
                'message' => $sql // Mengembalikan pertanyaan Gemini: "Mohon konfirmasi lokasi..."
            ], 200);
        }

        try {
            $data = DB::select($sql);

            // --- TAMBAHKAN LOGIC INSIGHT DI SINI ---

            // Gabungkan data hasil query menjadi teks singkat untuk dikirim ke Gemini
            $dataString = json_encode($data);
            $userPrompt = $request->input('message');

            $insightResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $apiKey,
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent", [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => "Berdasarkan data JSON berikut: $dataString. 
                                   Jawablah pertanyaan user: '$userPrompt' dengan gaya bahasa yang profesional dan ringkas (insight). 
                                   Gunakan Bahasa Indonesia."
                                    ]
                                ]
                            ]
                        ]
                    ]);

            $insight = $insightResponse->json('candidates.0.content.parts.0.text');

            return response()->json([
                'status' => 'success',
                'insight' => trim($insight), // Ini hasil rangkuman AI
                'query_generated' => $sql,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Query Execution Failed',
                'sql' => $sql,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenAI\Laravel\Facades\OpenAI;

class AiQueryController extends Controller
{
    public function __invoke(Request $request)
    {
        $question = $request->input('message');

        // Context untuk AI agar tahu tabel Anda
        $prompt = "Anda adalah asisten SQL PostgreSQL. Tabel: serial_number_data. 
                   Kolom: serial_number, status, so_item, plant, bagian, posting_date_assy.
                   Berikan HANYA string query SELECT. Pertanyaan: " . $question;

        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => [['role' => 'user', 'content' => $prompt]],
        ]);

        $sql = $result->choices[0]->message->content;

        // Eksekusi (Pastikan DB_CONNECTION di .env sudah benar ke PostgreSQL)
        $data = DB::select($sql);

        return response()->json([
            'query' => $sql,
            'results' => $data
        ]);
    }
}
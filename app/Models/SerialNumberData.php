<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SerialNumberData extends Model
{
    protected $table = 'serial_number_data';

    protected $guarded = [];

    protected $fillable = [
        'bagian',
        'status',
        'serial_number',
        'so_item',
        'plant',
        // Assembly
        'material_assy',
        'material_inspection_assy',
        'batch_assy',
        'batch_inspection_assy',
        'storage_assy',
        'storage_inspection_assy',
        'pro_assy',
        'pro_inspection_assy',
        'mrp_assy',
        'mrp_inspection_assy',
        'material_doc_assy',
        'material_doc_inspection_assy',
        'posting_date_assy',
        'posting_date_inspection_assy',
        'release_date_assy',
        'operator_assy',
        'operator_inspection_assy',
        // Painting
        'material_painting',
        'material_inspection_painting',
        'batch_painting',
        'batch_inspection_painting',
        'storage_painting',
        'storage_inspection_painting',
        'pro_painting',
        'pro_inspection_painting',
        'mrp_painting',
        'mrp_inspection_painting',
        'material_doc_painting',
        'material_doc_inspection_painting',
        'posting_date_painting',
        'posting_date_inspection_painting',
        'release_date_painting',
        'operator_painting',
        'operator_inspection_painting',
        // Packing
        'material_packing',
        'material_inspection_packing',
        'batch_packing',
        'batch_inspection_packing',
        'storage_packing',
        'storage_inspection_packing',
        'pro_packing',
        'pro_inspection_packing',
        'mrp_packing',
        'mrp_inspection_packing',
        'material_doc_packing',
        'material_doc_inspection_packing',
        'posting_date_packing',
        'posting_date_inspection_packing',
        'release_date_packing',
        'operator_packing',
        'operator_inspection_packing',
        // Bleaching
        'material_bleaching',
        'material_inspection_bleaching',
        'batch_bleaching',
        'batch_inspection_bleaching',
        'storage_bleaching',
        'storage_inspection_bleaching',
        'pro_bleaching',
        'pro_inspection_bleaching',
        'mrp_bleaching',
        'mrp_inspection_bleaching',
        'material_doc_bleaching',
        'material_doc_inspection_bleaching',
        'posting_date_bleaching',
        'posting_date_inspection_bleaching',
        'release_date_bleaching',
        'operator_bleaching',
        'operator_inspection_bleaching',
    ];

    /** @var array<string, string> */
    protected $casts = [
        // Assembly
        'posting_date_inspection_assy' => 'date:d-m-Y',
        'release_date_assy' => 'date:d-m-Y',
        // Painting
        'posting_date_painting' => 'date:d-m-Y',
        'posting_date_inspection_painting' => 'date:d-m-Y',
        'release_date_painting' => 'date:d-m-Y',
        // Packing
        'posting_date_packing' => 'date:d-m-Y',
        'posting_date_inspection_packing' => 'date:d-m-Y',
        'release_date_packing' => 'date:d-m-Y',
        // Bleaching
        'posting_date_bleaching' => 'date:d-m-Y',
        'posting_date_inspection_bleaching' => 'date:d-m-Y',
        'release_date_bleaching' => 'date:d-m-Y',
    ];
}

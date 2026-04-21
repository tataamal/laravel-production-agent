<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('serial_number_data', function (Blueprint $table) {
            $table->id();
            $table->string('bagian', 10)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('serial_number', 30)->nullable()->index();
            $table->string('so_item', 50)->nullable()->index();
            $table->string('plant', 10)->nullable();

            // Proses Assembly
            $table->string('material_assy', 40)->nullable();
            $table->string('material_inspection_assy', 40)->nullable();
            $table->string('batch_assy', 20)->nullable();
            $table->string('batch_inspection_assy', 20)->nullable();
            $table->string('storage_assy', 10)->nullable();
            $table->string('storage_inspection_assy', 10)->nullable();
            $table->string('pro_assy', 20)->nullable();
            $table->string('pro_inspection_assy', 20)->nullable();
            $table->string('mrp_assy', 10)->nullable();
            $table->string('mrp_inspection_assy', 10)->nullable();
            $table->string('material_doc_assy', 20)->nullable();
            $table->string('material_doc_inspection_assy', 20)->nullable();
            $table->date('posting_date_assy')->nullable();
            $table->date('posting_date_inspection_assy')->nullable();
            $table->date('release_date_assy')->nullable();
            $table->string('operator_assy', 20)->nullable();
            $table->string('operator_inspection_assy', 20)->nullable();

            // Proses Painting
            $table->string('material_painting', 40)->nullable();
            $table->string('material_inspection_painting', 40)->nullable();
            $table->string('batch_painting', 20)->nullable();
            $table->string('batch_inspection_painting', 20)->nullable();
            $table->string('storage_painting', 10)->nullable();
            $table->string('storage_inspection_painting', 10)->nullable();
            $table->string('pro_painting', 20)->nullable();
            $table->string('pro_inspection_painting', 20)->nullable();
            $table->string('mrp_painting', 10)->nullable();
            $table->string('mrp_inspection_painting', 10)->nullable();
            $table->string('material_doc_painting', 20)->nullable();
            $table->string('material_doc_inspection_painting', 20)->nullable();
            $table->date('posting_date_painting')->nullable();
            $table->date('posting_date_inspection_painting')->nullable();
            $table->date('release_date_painting')->nullable();
            $table->string('operator_painting', 20)->nullable();
            $table->string('operator_inspection_painting', 20)->nullable();

            // Proses Packing
            $table->string('material_packing', 40)->nullable();
            $table->string('material_inspection_packing', 40)->nullable();
            $table->string('batch_packing', 20)->nullable();
            $table->string('batch_inspection_packing', 20)->nullable();
            $table->string('storage_packing', 10)->nullable();
            $table->string('storage_inspection_packing', 10)->nullable();
            $table->string('pro_packing', 20)->nullable();
            $table->string('pro_inspection_packing', 20)->nullable();
            $table->string('mrp_packing', 10)->nullable();
            $table->string('mrp_inspection_packing', 10)->nullable();
            $table->string('material_doc_packing', 20)->nullable();
            $table->string('material_doc_inspection_packing', 20)->nullable();
            $table->date('posting_date_packing')->nullable();
            $table->date('posting_date_inspection_packing')->nullable();
            $table->date('release_date_packing')->nullable();
            $table->string('operator_packing', 20)->nullable();
            $table->string('operator_inspection_packing', 20)->nullable();

            // Proses Bleaching
            $table->string('material_bleaching', 40)->nullable();
            $table->string('material_inspection_bleaching', 40)->nullable();
            $table->string('batch_bleaching', 20)->nullable();
            $table->string('batch_inspection_bleaching', 20)->nullable();
            $table->string('storage_bleaching', 10)->nullable();
            $table->string('storage_inspection_bleaching', 10)->nullable();
            $table->string('pro_bleaching', 20)->nullable();
            $table->string('pro_inspection_bleaching', 20)->nullable();
            $table->string('mrp_bleaching', 10)->nullable();
            $table->string('mrp_inspection_bleaching', 10)->nullable();
            $table->string('material_doc_bleaching', 20)->nullable();
            $table->string('material_doc_inspection_bleaching', 20)->nullable();
            $table->date('posting_date_bleaching')->nullable();
            $table->date('posting_date_inspection_bleaching')->nullable();
            $table->date('release_date_bleaching')->nullable();
            $table->string('operator_bleaching', 20)->nullable();
            $table->string('operator_inspection_bleaching', 20)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('serial_number_data');
    }
};

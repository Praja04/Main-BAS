<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->string('req_number')->unique();
            $table->date('request_date');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Tipe request: New Doc., Obsolete, Revise
            $table->string('type_of_req');
            $table->integer('revision_number')->nullable(); // Jika revise ke berapa
            
            // Tipe dokumen: Form Digital, Logbook, SOP, Form Manual, Manual, WI, dll
            $table->string('type_of_doc');
            
            // Nomor dan Judul Dokumen (Bisa dari MLOD atau baru)
            $table->string('doc_number')->nullable();
            $table->string('doc_title')->nullable();
            
            // Deskripsi perubahan
            $table->text('detail_before')->nullable();
            $table->text('detail_after')->nullable();
            
            // File attachment PDF
            $table->string('file_path')->nullable();
            
            // Status: Waiting Check..., Revise, Reject, Approved, Complete
            $table->string('status')->default('Waiting Check...');
            
            // Maksimal revise 2x
            $table->integer('revision_count')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};

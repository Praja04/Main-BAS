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
        Schema::create('download_logs', function (Blueprint $table) {
            $table->id();
            
            // Siapa yang mendownload
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Dokumen mana yang didownload (misal dari MasterDocument)
            $table->foreignId('master_document_id')->constrained('master_documents')->cascadeOnDelete();
            
            // Kapan didownload
            $table->timestamp('downloaded_at')->useCurrent();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_logs');
    }
};

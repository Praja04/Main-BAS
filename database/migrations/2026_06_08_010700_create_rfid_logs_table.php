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
        Schema::create('rfid_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sn_card');       // SN Card dari RFID, boleh duplikat (tidak unique)
            $table->timestamp('timestamp');   // Waktu scan RFID
            $table->timestamps();

            $table->index('sn_card');         // Index untuk pencarian cepat berdasarkan SN Card
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfid_logs');
    }
};

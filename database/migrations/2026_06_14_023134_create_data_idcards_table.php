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
        Schema::create('data_idcard', function (Blueprint $table) {
            $table->id();
            $table->string('sn_card')->unique(); // SN Card dari RFID, unik untuk data master
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->string('dept')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_idcard');
    }
};

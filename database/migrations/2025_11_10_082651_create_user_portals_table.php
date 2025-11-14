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
        Schema::create('user_portals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('portal_name'); // 'engineering', 'warehouse', 'main'
            $table->string('portal_url'); // http://10.11.10.130:8090/engineering/public/
            $table->string('username');
            $table->string('password'); // akan di-encrypt
            $table->timestamps();

            $table->unique(['user_id', 'portal_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_portals');
    }
};

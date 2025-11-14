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
        Schema::create('portal_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('portal_name'); // Nama portal
            $table->string('portal_url'); // URL portal
            $table->string('username')->encrypted(); // Username terenkripsi
            $table->string('password')->encrypted(); // Password terenkripsi
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Icon/logo portal
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'portal_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_credentials');
    }
};

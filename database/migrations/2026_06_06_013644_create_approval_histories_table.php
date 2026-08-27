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
        Schema::create('approval_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_request_id')->constrained('document_requests')->cascadeOnDelete();
            
            // Approver id (Manager atau IMS)
            $table->foreignId('approver_id')->constrained('users')->cascadeOnDelete();
            
            // Step: 'Manager', 'DC Center'
            $table->string('step');
            
            // Status action yang diambil: 'Approved', 'Rejected', 'Revise', dll
            $table->string('status');
            
            // Komentar jika di reject atau revise
            $table->text('remarks')->nullable();
            
            $table->timestamp('processed_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_histories');
    }
};

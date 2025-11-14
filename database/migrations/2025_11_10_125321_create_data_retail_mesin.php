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
        Schema::create('data_retail_mesin', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('mesin_retail');
            $table->integer('total_counter');

            // Shift 1
            $table->float('uptime_percent_shift_1')->nullable();
            $table->integer('uptime_minutes_shift_1')->nullable();
            $table->float('downtime_percent_shift_1')->nullable();
            $table->integer('downtime_minutes_shift_1')->nullable();
            $table->float('performance_output_shift_1')->nullable();

            // Shift 2
            $table->float('uptime_percent_shift_2')->nullable();
            $table->integer('uptime_minutes_shift_2')->nullable();
            $table->float('downtime_percent_shift_2')->nullable();
            $table->integer('downtime_minutes_shift_2')->nullable();
            $table->float('performance_output_shift_2')->nullable();

            // Shift 3
            $table->float('uptime_percent_shift_3')->nullable();
            $table->integer('uptime_minutes_shift_3')->nullable();
            $table->float('downtime_percent_shift_3')->nullable();
            $table->integer('downtime_minutes_shift_3')->nullable();
            $table->float('performance_output_shift_3')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_retail_mesin');
    }
};

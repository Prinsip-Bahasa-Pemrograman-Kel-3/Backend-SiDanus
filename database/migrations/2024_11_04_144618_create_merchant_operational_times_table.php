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
        Schema::create('merchant_operational_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_id')
                ->nullable()
                ->references('id')
                ->on('days')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('merchant_id')
                ->nullable()
                ->references('id')
                ->on('merchants')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_operational_times');
    }
};

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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('status', ['Berlangsung', 'Selesai', 'Dibatalkan']);
            $table->decimal('total_amount');
            $table->foreignId('merchant_id')
                ->nullable()
                ->references('id')
                ->on('merchants')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('shipment_type_id')
                ->nullable()
                ->references('id')
                ->on('shipment_types')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('payment_type_id')
                ->nullable()
                ->references('id')
                ->on('payment_types')
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
        Schema::dropIfExists('transactions');
    }
};

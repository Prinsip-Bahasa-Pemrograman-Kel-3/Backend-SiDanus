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
        Schema::create('transaction_cancellations', function (Blueprint $table) {
            $table->id();
            $table->text('description')
                ->nullable();
            $table->foreignId('reason_cancellation_id')
                ->nullable()
                ->references('id')
                ->on('transaction_cancellations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('transaction_id')
                ->nullable()
                ->references('id')
                ->on('transactions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::table('reason_cancellations', function($table) {
            $table->foreignId('transaction_cancellation_id')
                ->nullable()
                ->references('id')
                ->on('transaction_cancellations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reason_transaction_cancellations', function($table) {
            $table->dropColumn('transaction_cancellation_id');
        });
        Schema::dropIfExists('transaction_cancellations');
    }
};

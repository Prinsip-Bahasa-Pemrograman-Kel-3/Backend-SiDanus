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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price');
            $table->bigInteger('stock');
            $table->bigInteger('minimum_order');
            $table->text('description');
            $table->foreignId('merchant_id')
                ->nullable()
                ->references('id')
                ->on('merchants')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('product_category_id')
                ->nullable()
                ->references('id')
                ->on('product_categories')
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
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('business_phone')
                ->nullable();
            $table->string('business_email')
                ->nullable();
            $table->text('id_card_image');
            $table->text('avatar')
                ->nullable();
                $table->foreignId('student_id')
                ->nullable()
                ->references('id')
                ->on('students')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('organization_id')
                ->nullable()
                ->references('id')
                ->on('organizations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('event_id')
                ->nullable()
                ->references('id')
                ->on('events')
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
        Schema::dropIfExists('merchants');
    }
};

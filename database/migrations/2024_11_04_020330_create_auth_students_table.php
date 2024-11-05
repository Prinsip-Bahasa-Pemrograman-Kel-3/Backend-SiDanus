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
        Schema::create('auth_students', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 255);
            $table->string('avatar')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('major_id')->constrained();
            $table->foreignId('organization_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_students');
    }
};

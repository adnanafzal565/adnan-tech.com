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
        Schema::create('form_attempts', function (Blueprint $table) {
            $table->id();
            $table->string("token", 64)->unique();
            $table->string("form_type", 100)->nullable();
            $table->timestamp("started_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_attempts');
    }
};

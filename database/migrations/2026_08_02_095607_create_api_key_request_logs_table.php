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
        Schema::create('api_key_request_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("api_key_id")->nullable();
            $table->foreign("api_key_id")->references("id")->on("api_keys")->onUpdate("CASCADE")->onDelete("CASCADE");

            $table->string("title")->nullable();
            $table->text("content")->nullable();
            $table->text("device")->nullable();
            $table->string("ip")->nullable();
            $table->unsignedBigInteger("remaining")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_request_logs');
    }
};

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
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onUpdate("CASCADE")->onDelete("SET NULL");
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->double('price')->nullable();
            $table->text("excerpt")->nullable();
            $table->longText('content')->nullable();
            $table->json('categories')->nullable();
            $table->json('tags')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
            $table->softDeletes();
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

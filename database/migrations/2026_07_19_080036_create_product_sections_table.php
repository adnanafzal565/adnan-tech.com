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
        Schema::create('product_sections', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("product_id");
            $table->foreign("product_id")
                ->references("id")
                ->on("products")
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->string("title")->nullable();
            $table->longText("description")->nullable();

            $table->enum("type", [
                "text",
                "text_with_image",
                "text_with_video",
            ])->default("text");

            $table->text("url")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sections');
    }
};

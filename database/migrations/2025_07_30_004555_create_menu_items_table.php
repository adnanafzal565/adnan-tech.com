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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("menu_id")->nullable();
            $table->foreign("menu_id")->references("id")->on("menus")->onUpdate("CASCADE")->onDelete("CASCADE");
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->integer('parent_id')->nullable(); // for nested menus
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};

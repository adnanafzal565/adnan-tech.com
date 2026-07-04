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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();          // custom name
            $table->string('file_path')->nullable();                 // stored file path
            $table->string('alt')->nullable();           // alt attribute
            $table->string('caption')->nullable();       // short caption
            $table->text('description')->nullable();
            $table->enum("type", ["public", "private"])->default("public");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};

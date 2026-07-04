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
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('name')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('installations')->default(0);
            $table->json('projects')->nullable();

            // Optional: foreign key (uncomment if needed)
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate("CASCADE")
                ->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addons');
    }
};

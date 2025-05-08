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
        Schema::create('casas', function (Blueprint $table) {
            $table->id();
            $table->string('endereco');
            $table->integer('sala')->default(1);
            $table->integer('quarto')->default(1);
            $table->integer('casaDeBanho')->default(1);
            $table->integer('cozinha')->default(1);
            $table->foreignId('pessoa_id')->constrained('pessoas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casa');
    }
};

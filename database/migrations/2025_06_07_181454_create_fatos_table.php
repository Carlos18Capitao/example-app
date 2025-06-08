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
        Schema::create('fatos', function (Blueprint $table) {
            $table->id();
            $table->string('cor');
            $table->string('quantidade');
            $table->foreignId('casaco_id')->constrained('casacos')->onDelete('cascade'); // Foreign key to clientes table
            $table->foreignId('calca_id')->constrained('calcas')->onDelete('cascade'); // Foreign key to calcas table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fatos');
    }
};

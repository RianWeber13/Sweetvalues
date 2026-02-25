<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do ingrediente
            $table->string('unit'); // Unidade (kg, g, un, ml)
            $table->decimal('purchase_price', 10, 2); // Preço que você pagou
            $table->decimal('package_size', 10, 2); // Tamanho da embalagem (ex: 395g)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
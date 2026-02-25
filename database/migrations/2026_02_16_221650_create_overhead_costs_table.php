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
        Schema::create('overhead_costs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['fixed', 'percentage']);
            $table->decimal('value', 10, 2); // Stores fixed amount or percentage value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overhead_costs');
    }
};
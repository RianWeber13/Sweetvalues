<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid issues when truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables to remove existing data (including pivots)
        DB::table('recipe_ingredient')->truncate();
        Ingredient::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $ingredients = [
            ['name' => 'Açúcar Refinado', 'unit' => 'kg', 'purchase_price' => 5.50, 'package_size' => 1],
            ['name' => 'Farinha de Trigo', 'unit' => 'kg', 'purchase_price' => 6.00, 'package_size' => 1],
            ['name' => 'Leite Condensado', 'unit' => 'g', 'purchase_price' => 7.90, 'package_size' => 395],
            ['name' => 'Creme de Leite', 'unit' => 'g', 'purchase_price' => 3.50, 'package_size' => 200],
            ['name' => 'Manteiga Sem Sal', 'unit' => 'g', 'purchase_price' => 12.00, 'package_size' => 200],
            ['name' => 'Ovos', 'unit' => 'un', 'purchase_price' => 15.00, 'package_size' => 12],
            ['name' => 'Chocolate em Pó 50%', 'unit' => 'g', 'purchase_price' => 25.00, 'package_size' => 1000],
            ['name' => 'Chocolate Nobre Meio Amargo', 'unit' => 'g', 'purchase_price' => 45.00, 'package_size' => 1000],
            ['name' => 'Essência de Baunilha', 'unit' => 'ml', 'purchase_price' => 8.00, 'package_size' => 30],
            ['name' => 'Fermento em Pó', 'unit' => 'g', 'purchase_price' => 4.50, 'package_size' => 100],
            ['name' => 'Leite Integral', 'unit' => 'l', 'purchase_price' => 4.80, 'package_size' => 1],
            ['name' => 'Coco Ralado', 'unit' => 'g', 'purchase_price' => 6.50, 'package_size' => 100],
        ];

        foreach ($ingredients as $ing) {
            Ingredient::create($ing);
        }
    }
}
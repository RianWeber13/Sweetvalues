<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'ingredientes' => Ingredient::count(),
            'receitas'     => Recipe::count(),
            'produtos'     => Product::count(),
            'usuarios'     => User::count(),
        ];

        $produtoMaisRecente = Product::with(['recipes', 'overheadCosts'])
            ->latest()
            ->first();

        $ingredienteMaisRecente = Ingredient::latest()->first();

        return view('dashboard', compact('stats', 'produtoMaisRecente', 'ingredienteMaisRecente'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::with('ingredients')->get();
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('recipes.create', compact('ingredients'));
    }

    /**
     * Store a newly created recipe in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'yield_quantity' => 'required|numeric|min:0.01',
            'yield_unit' => 'required|string|max:50',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $recipe = Recipe::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'yield_quantity' => $validated['yield_quantity'],
            'yield_unit' => $validated['yield_unit'],
        ]);

        foreach ($validated['ingredients'] as $ingredient) {
            $recipe->ingredients()->attach($ingredient['id'], ['quantity_used' => $ingredient['quantity']]);
        }

        return redirect()->route('recipes.index')->with('success', 'Receita criada com sucesso! Custo Total: R$ ' . number_format($recipe->total_cost, 2, ',', '.'));
    }
}
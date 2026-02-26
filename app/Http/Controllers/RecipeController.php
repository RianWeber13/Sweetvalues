<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\OverheadCost;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with(['ingredients', 'overheadCosts'])->get();
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $overheadCosts = OverheadCost::orderBy('name')->get();
        return view('recipes.create', compact('ingredients', 'overheadCosts'));
    }

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
            'overhead_cost_ids' => 'nullable|array',
            'overhead_cost_ids.*' => 'exists:overhead_costs,id',
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

        $recipe->overheadCosts()->sync($validated['overhead_cost_ids'] ?? []);

        return redirect()->route('recipes.index')->with('success', 'Receita criada com sucesso! Custo Total: R$ ' . number_format($recipe->total_cost, 2, ',', '.'));
    }

    public function edit(Recipe $recipe)
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $overheadCosts = OverheadCost::orderBy('name')->get();
        $recipe->load(['ingredients', 'overheadCosts']);
        return view('recipes.edit', compact('recipe', 'ingredients', 'overheadCosts'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'yield_quantity' => 'required|numeric|min:0.01',
            'yield_unit' => 'required|string|max:50',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
            'overhead_cost_ids' => 'nullable|array',
            'overhead_cost_ids.*' => 'exists:overhead_costs,id',
        ]);

        $recipe->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'yield_quantity' => $validated['yield_quantity'],
            'yield_unit' => $validated['yield_unit'],
        ]);

        $syncData = [];
        foreach ($validated['ingredients'] as $ingredient) {
            $syncData[$ingredient['id']] = ['quantity_used' => $ingredient['quantity']];
        }
        $recipe->ingredients()->sync($syncData);

        $recipe->overheadCosts()->sync($validated['overhead_cost_ids'] ?? []);

        return redirect()->route('recipes.index')->with('success', 'Receita atualizada com sucesso! Custo Total: R$ ' . number_format($recipe->total_cost, 2, ',', '.'));
    }
}

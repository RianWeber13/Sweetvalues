<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Recipe;
use App\Models\OverheadCost;

class ProductController extends Controller
{
    public const CATEGORIES = [
        'Cookies',
        'Salgados',
        'Doces de Festa',
        'Sobremesas',
        'Bolos',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        if ($category) {
            $products = Product::with(['recipes', 'overheadCosts'])
                ->where('category', $category)
                ->get();
        } else {
            $products = collect();
        }

        return view('products.index', [
            'products'   => $products,
            'categories' => self::CATEGORIES,
            'category'   => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recipes = Recipe::all();
        $overheadCosts = OverheadCost::all();
        $categories = self::CATEGORIES;
        return view('products.create', compact('recipes', 'overheadCosts', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'nullable|string|in:' . implode(',', self::CATEGORIES),
            'profit_margin' => 'required|numeric|min:0',
            'recipes'       => 'array',
            'recipes.*.id'       => 'required|exists:recipes,id',
            'recipes.*.quantity' => 'required|numeric|min:0.01',
            'overhead_costs'   => 'array',
            'overhead_costs.*' => 'exists:overhead_costs,id',
        ]);

        $product = Product::create([
            'name'          => $validated['name'],
            'category'      => $validated['category'] ?? null,
            'profit_margin' => $validated['profit_margin'],
        ]);

        if (isset($validated['recipes'])) {
            foreach ($validated['recipes'] as $recipeData) {
                if ($recipeData['quantity'] > 0) {
                    $product->recipes()->attach($recipeData['id'], ['quantity' => $recipeData['quantity']]);
                }
            }
        }

        if (isset($validated['overhead_costs'])) {
            $product->overheadCosts()->attach($validated['overhead_costs']);
        }

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['recipes', 'overheadCosts']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $recipes = Recipe::all();
        $overheadCosts = OverheadCost::all();
        $categories = self::CATEGORIES;
        $product->load(['recipes', 'overheadCosts']);

        return view('products.edit', compact('product', 'recipes', 'overheadCosts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'nullable|string|in:' . implode(',', self::CATEGORIES),
            'profit_margin' => 'required|numeric|min:0',
            'recipes'       => 'array',
            'recipes.*.id'       => 'required|exists:recipes,id',
            'recipes.*.quantity' => 'required|numeric|min:0.01',
            'overhead_costs'   => 'array',
            'overhead_costs.*' => 'exists:overhead_costs,id',
        ]);

        $product->update([
            'name'          => $validated['name'],
            'category'      => $validated['category'] ?? null,
            'profit_margin' => $validated['profit_margin'],
        ]);

        // Sync Recipes
        $recipesSync = [];
        if (isset($validated['recipes'])) {
            foreach ($validated['recipes'] as $recipeData) {
                if ($recipeData['quantity'] > 0) {
                    $recipesSync[$recipeData['id']] = ['quantity' => $recipeData['quantity']];
                }
            }
        }
        $product->recipes()->sync($recipesSync);

        // Sync Overhead Costs
        $product->overheadCosts()->sync($validated['overhead_costs'] ?? []);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto removido com sucesso.');
    }
}
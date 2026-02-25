<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    // 1. Abre a página do formulário
    public function create()
    {
        return view('ingredients.create');
    }

    // 2. Salva os dados e redireciona o usuário
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'unit' => 'required|string',
            'purchase_price' => 'required|numeric',
            'package_size' => 'required|numeric',
        ]);

        Ingredient::create($validated);

        // Retorna para a lista com mensagem de sucesso
        return redirect()->route('ingredients.index')->with('success', 'Ingrediente salvo com sucesso!');
    }

    // 3. Lista os ingredientes (opcional para agora)
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));

    }

    // 4. Edita o ingrediente
    public function edit($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return view('ingredients.edit', compact('ingredient'));
    }

    // 5. Atualiza o ingrediente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'unit' => 'required|string',
            'purchase_price' => 'required|numeric',
            'package_size' => 'required|numeric',
        ]);

        $ingredient = Ingredient::findOrFail($id);
        $ingredient->update($validated);

        return redirect()->route('ingredients.index')->with('success', 'Ingrediente atualizado com sucesso!');
    }
}
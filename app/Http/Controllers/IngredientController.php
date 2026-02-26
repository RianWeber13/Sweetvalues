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
    // 1. Captura todos os dados da requisição
    $data = $request->all();

    // 2. Sanitização (Tratamento da vírgula para ponto)
    if (isset($data['purchase_price'])) {
        // Primeiro remove pontos de milhar (ex: 1.250 -> 1250)
        // Depois troca a vírgula decimal por ponto (ex: 5,50 -> 5.50)
        $data['purchase_price'] = str_replace(',', '.', str_replace('.', '', $data['purchase_price']));
    }

    // 3. Sincronização dos dados tratados com a Request
    // Substituímos o valor original da request pelo valor formatado para que a validação funcione
    $request->merge(['purchase_price' => $data['purchase_price']]);

    // 4. Validação Técnica
    $validated = $request->validate([
        'name'           => 'required|string|max:255',
        'unit'           => 'required|string',
        'package_size'   => 'required|numeric',
        'purchase_price' => 'required|numeric', // Agora o Laravel entende como número válido
    ]);

    // 5. Persistência no Banco de Dados (PostgreSQL)
    // O Eloquent usa os dados validados (já com o ponto decimal) para criar o registro
    Ingredient::create($validated);

    // 6. Resposta ao Usuário e Redirecionamento
    return redirect()->route('ingredients.index')
        ->with('success', 'Ingrediente salvo com sucesso!');
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
        if ($request->has('purchase_price')) {
            $request->merge([
                'purchase_price' => str_replace(',', '.', str_replace('.', '', $request->purchase_price)),
            ]);
        }

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
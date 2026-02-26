@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ __('Editar Receita') }}
                    </h2>
                </div>

                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sucesso!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                <form action="{{ route('recipes.update', $recipe->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Recipe Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nome da Receita') }}</label>
                            <input id="name"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                type="text" name="name" value="{{ old('name', $recipe->name) }}" required autofocus />
                            @error('name')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="yield_quantity" class="block font-medium text-sm text-gray-700">{{ __('Quantidade de Rendimento em Gramas (g)') }}</label>
                            <input id="yield_quantity"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                type="number" step="0.01" min="0.01" name="yield_quantity" value="{{ old('yield_quantity', $recipe->yield_quantity) }}" required />
                            <input type="hidden" name="yield_unit" value="g">
                            @error('yield_quantity')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Descrição / Modo de Preparo') }}</label>
                            <textarea id="description" name="description"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3">{{ old('description', $recipe->description) }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Custos de Produção</h3>
                    @if($overheadCosts->isEmpty())
                    <p class="text-sm text-gray-500 mb-4">
                        Nenhum custo cadastrado. <a href="{{ route('overhead_costs.create') }}" class="underline text-indigo-600">Cadastre aqui</a>.
                    </p>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                        @foreach($overheadCosts as $cost)
                        <label class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer hover:bg-indigo-50">
                            <input type="checkbox" name="overhead_cost_ids[]" value="{{ $cost->id }}"
                                {{ $recipe->overheadCosts->contains($cost->id) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm text-gray-700">
                                {{ $cost->name }}
                                <span class="text-gray-400">
                                    ({{ $cost->type === 'fixed' ? 'R$ ' . number_format($cost->value, 2, ',', '.') : $cost->value . '%' }})
                                </span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @endif

                    <hr class="my-6 border-gray-200">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ingredientes</h3>

                    <div id="ingredients-container">
                        <!-- Dynamic rows will be added here -->
                    </div>

                    <div class="mt-4 flex gap-4">
                        <button type="button" id="add-ingredient-btn"
                            class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Adicionar Ingrediente
                        </button>
                        @if($ingredients->isEmpty())
                        <span class="text-red-500 text-sm self-center">Nenhum ingrediente cadastrado. <a
                                href="{{ route('ingredients.create') }}" class="underline">Cadastre aqui</a>.</span>
                        @endif
                        @error('ingredients')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-8 gap-4">
                        <a href="{{ route('recipes.index') }}"
                            class="text-gray-600 hover:text-gray-900 font-medium">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-pink-600 text-white font-bold py-2 px-4 rounded hover:bg-pink-700 transition duration-200">
                            {{ __('Salvar Alterações') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('ingredients-container');
        const addBtn = document.getElementById('add-ingredient-btn');
        const ingredients = @json($ingredients);
        const existingIngredients = @json($recipe->ingredients->map(fn($i) => ['id' => $i->id, 'quantity' => $i->pivot->quantity_used]));

        let ingredientIndex = 0;

        function addIngredientRow(selectedId = null, selectedQty = null) {
            const rowId = `row-${ingredientIndex}`;
            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-6 gap-4 mb-4 items-end p-4 bg-gray-50 rounded-lg border border-gray-200';
            row.id = rowId;

            let options = '<option value="">Selecione um ingrediente</option>';
            ingredients.forEach(ing => {
                const selected = selectedId && ing.id == selectedId ? 'selected' : '';
                options += `<option value="${ing.id}" ${selected}>${ing.name} (${ing.unit})</option>`;
            });

            row.innerHTML = `
                <div class="md:col-span-3">
                    <label class="block font-medium text-sm text-gray-700">Ingrediente</label>
                    <select name="ingredients[${ingredientIndex}][id]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        ${options}
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block font-medium text-sm text-gray-700">Quantidade Usada</label>
                    <input type="number" step="0.01" name="ingredients[${ingredientIndex}][quantity]" value="${selectedQty ?? ''}" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                </div>
                <div class="md:col-span-1 text-right">
                    <button type="button" onclick="removeIngredientRow('${rowId}')" class="text-red-600 hover:text-red-900 font-bold text-xl" title="Remover">&times;</button>
                </div>
            `;

            container.appendChild(row);
            ingredientIndex++;
        }

        window.removeIngredientRow = function (rowId) {
            const row = document.getElementById(rowId);
            if (row) row.remove();
        };

        if (addBtn) addBtn.addEventListener('click', () => addIngredientRow());

        // Load existing ingredients
        if (existingIngredients.length > 0) {
            existingIngredients.forEach(ei => addIngredientRow(ei.id, ei.quantity));
        } else if (ingredients.length > 0) {
            addIngredientRow();
        }
    });
</script>
@endsection

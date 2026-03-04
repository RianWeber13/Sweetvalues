@extends('layouts.app')

@section('content')
<h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
    {{ __('Editar Produto') }}
</h2>

<div x-data="productCalculator()" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6">

            <!-- Left Column: Product Form -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form method="POST" action="{{ route('products.update', $product) }}">
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-bold mb-2">{{ __('Nome do Produto')
                                    }}</label>
                                <input id="name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500"
                                    type="text" name="name" value="{{ old('name', $product->name) }}" required
                                    autofocus />
                                @error('name')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-4">
                                <label for="category" class="block text-gray-700 font-bold mb-2">Categoria</label>
                                <select id="category" name="category"
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
                                    <option value="">Sem categoria</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Recipes Selection -->
                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Receitas utilizadas
                                </h3>

                                <div class="space-y-3">
                                    <template x-for="(item, index) in selectedRecipes" :key="index">
                                        <div class="bg-gray-50 p-3 rounded-md border border-gray-200">
                                            <!-- Header -->
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="text-sm font-medium text-gray-700" x-text="item.name"></span>
                                                    <span class="text-xs text-gray-500 ml-1">
                                                        (R$ <span x-text="formatMoney(item.unitCost)"></span> / <span x-text="item.yieldUnit"></span>)
                                                    </span>
                                                </div>
                                                <button type="button" @click="removeRecipe(index)" class="text-red-600 hover:text-red-900 ml-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Hidden inputs -->
                                            <input type="hidden" :name="'recipes['+index+'][id]'" :value="item.id">
                                            <input type="hidden" :name="'recipes['+index+'][quantity]'" :value="item.quantity">

                                            <!-- Mode toggle -->
                                            <div class="flex flex-wrap gap-4 mt-2 text-sm">
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" value="full" x-model="item.useFullRecipe"
                                                        @change="setFullRecipe(item)"
                                                        class="text-pink-600 focus:ring-pink-500">
                                                    <span>Receita completa (<span x-text="item.yieldQuantity"></span>g)</span>
                                                </label>
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" value="partial" x-model="item.useFullRecipe"
                                                        @change="calculateTotal()"
                                                        class="text-pink-600 focus:ring-pink-500">
                                                    <span>Porção específica</span>
                                                </label>
                                            </div>

                                            <!-- Partial quantity input -->
                                            <div x-show="item.useFullRecipe === 'partial'" class="mt-2 flex items-center gap-2">
                                                <label class="text-xs font-medium text-gray-700">Quantidade (g):</label>
                                                <input type="number" step="0.01" min="0.01"
                                                    x-model="item.quantity" @input="calculateTotal()"
                                                    class="w-28 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <select x-model="newRecipeId"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Selecione uma receita...</option>
                                        @foreach($recipes as $recipe)
                                        @php
                                        $unitCost = $recipe->yield_quantity > 0 ? $recipe->total_cost /
                                        $recipe->yield_quantity : 0;
                                        @endphp
                                        <option value="{{ $recipe->id }}"
                                            data-name="{{ $recipe->name }}"
                                            data-unit-cost="{{ $unitCost }}"
                                            data-yield-unit="{{ $recipe->yield_unit }}"
                                            data-yield-quantity="{{ $recipe->yield_quantity }}">
                                            {{ $recipe->name }} (R$ {{ number_format($unitCost, 2, ',', '.') }} / {{ $recipe->yield_unit }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="button" @click="addRecipe()"
                                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Adicionar</button>
                                </div>
                                @error('recipes')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Overhead Costs Selection -->
                            <div class="mt-8">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Custos Indiretos /
                                    Despesas</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @php
                                    $selectedOverheadIds = $product->overheadCosts->pluck('id')->toArray();
                                    @endphp
                                    @foreach($overheadCosts as $cost)
                                    <div class="flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input id="overhead_cost_{{ $cost->id }}" name="overhead_costs[]"
                                                type="checkbox" value="{{ $cost->id }}" {{ in_array($cost->id,
                                            $selectedOverheadIds) ? 'checked' : '' }}
                                            @change="toggleOverhead({{ $cost->id }}, '{{ $cost->type }}', {{ $cost->value }}, '{{ $cost->name }}')"
                                            class="h-4 w-4 rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="overhead_cost_{{ $cost->id }}"
                                                class="font-medium text-gray-700">{{ $cost->name }}</label>
                                            <p class="text-gray-500">
                                                @if($cost->type == 'fixed') R$ {{ $cost->value }} @else {{ $cost->value
                                                }}% @endif
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Profit Margin -->
                            <div class="mt-6 border-t pt-4">
                                <label for="profit_margin" class="block text-gray-700 font-bold mb-2">{{ __('Margem de
                                    Lucro (%)') }}</label>
                                <input id="profit_margin"
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500"
                                    type="number" step="0.1" name="profit_margin" x-model="profitMargin"
                                    @input="calculateTotal()" required />
                                @error('profit_margin')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                    {{ __('Cancelar') }}
                                </a>
                                <button type="submit"
                                    class="bg-pink-600 text-white font-bold py-2 px-4 rounded hover:bg-pink-700 transition duration-200">
                                    {{ __('Atualizar Produto') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Live Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">Resumo do Preço</h3>

                        <div class="space-y-3">
                            <!-- Recipe breakdown -->
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Receitas</p>
                                <p class="text-xs text-gray-400 italic" x-show="totals.recipeBreakdown.length === 0">Nenhuma receita adicionada</p>
                                <template x-for="item in totals.recipeBreakdown" :key="item.name">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600" x-text="item.name"></span>
                                        <span class="font-medium">R$ <span x-text="formatMoney(item.cost)"></span></span>
                                    </div>
                                </template>
                            </div>

                            <!-- Overhead breakdown -->
                            <div class="border-t pt-2" x-show="totals.overheadBreakdown.length > 0">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Custos Indiretos</p>
                                <template x-for="item in totals.overheadBreakdown" :key="item.name">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600" x-text="item.name"></span>
                                        <span class="font-medium text-orange-600">+ R$ <span x-text="formatMoney(item.cost)"></span></span>
                                    </div>
                                </template>
                            </div>

                            <div class="border-t pt-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-800 font-semibold">Custo Total:</span>
                                    <span class="font-bold">R$ <span x-text="formatMoney(totals.totalCost)"></span></span>
                                </div>
                                <div class="flex justify-between text-sm mt-1" x-show="totals.profitAmount > 0">
                                    <span class="text-gray-600">Margem (<span x-text="profitMargin"></span>%):</span>
                                    <span class="font-medium text-green-600">+ R$ <span x-text="formatMoney(totals.profitAmount)"></span></span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center bg-green-50 p-2 rounded border border-green-200 mt-2">
                                <span class="text-green-800 font-semibold">Preço Sugerido:</span>
                                <span class="font-bold text-xl text-green-700">R$ <span x-text="formatMoney(totals.suggestedPrice)"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productCalculator', () => ({
            selectedRecipes: [],
            newRecipeId: '',
            profitMargin: {{ old('profit_margin', $product-> profit_margin)
    }},
        selectedOverheads: {}, // Map of id: {type, value, name}
        totals: {
        material: 0,
        overhead: 0,
        totalCost: 0,
        suggestedPrice: 0,
        recipeBreakdown: [],
        overheadBreakdown: [],
        profitAmount: 0
    },

        init() {
        // Pre-fill selected recipes
        const rawRecipes = @json($product -> recipes);
        rawRecipes.forEach(r => {
            const unitCost = r.yield_quantity > 0 ? r.total_cost / r.yield_quantity : 0;
            const isFullRecipe = parseFloat(r.pivot.quantity) === parseFloat(r.yield_quantity) ? 'full' : 'partial';
            this.selectedRecipes.push({
                id: r.id,
                name: r.name,
                quantity: r.pivot.quantity,
                yieldQuantity: r.yield_quantity,
                unitCost: unitCost,
                yieldUnit: r.yield_unit,
                useFullRecipe: isFullRecipe
            });
        });

        // Pre-fill selected overheads
        const rawOverheads = @json($product -> overheadCosts);
        rawOverheads.forEach(c => {
            this.selectedOverheads[c.id] = { type: c.type, value: parseFloat(c.value), name: c.name };
        });

        this.calculateTotal();
    },

        addRecipe() {
        if (!this.newRecipeId) return;

        const select = document.querySelector(`select[x-model="newRecipeId"]`);
        const option = select.options[select.selectedIndex];
        const name = option.getAttribute('data-name');
        const unitCost = parseFloat(option.getAttribute('data-unit-cost'));
        const yieldUnit = option.getAttribute('data-yield-unit');
        const yieldQuantity = parseFloat(option.getAttribute('data-yield-quantity'));

        if (this.selectedRecipes.some(r => r.id == this.newRecipeId)) {
            alert('Receita já adicionada');
            return;
        }

        this.selectedRecipes.push({
            id: this.newRecipeId,
            name: name,
            quantity: yieldQuantity,
            yieldQuantity: yieldQuantity,
            unitCost: unitCost,
            yieldUnit: yieldUnit,
            useFullRecipe: 'full'
        });

        this.newRecipeId = '';
        this.calculateTotal();
        },

    setFullRecipe(item) {
        if (item.useFullRecipe === 'full') {
            item.quantity = item.yieldQuantity;
        }
        this.calculateTotal();
    },

    removeRecipe(index) {
        this.selectedRecipes.splice(index, 1);
        this.calculateTotal();
    },

    toggleOverhead(id, type, value, name) {
        if (this.selectedOverheads[id]) {
            delete this.selectedOverheads[id];
        } else {
            this.selectedOverheads[id] = { type, value: parseFloat(value), name };
        }
        this.calculateTotal();
    },

    calculateTotal() {
        // 1. Calculate Material Cost (Sum of Recipes)
        let materialCost = 0;
        let recipeBreakdown = [];
        this.selectedRecipes.forEach(item => {
            const cost = (parseFloat(item.quantity) || 0) * item.unitCost;
            materialCost += cost;
            recipeBreakdown.push({ name: item.name, cost: cost });
        });

        // 2. Calculate Overhead Cost
        let overheadTotal = 0;
        let overheadBreakdown = [];
        Object.values(this.selectedOverheads).forEach(cost => {
            let amount;
            if (cost.type === 'fixed') {
                amount = cost.value;
            } else {
                amount = materialCost * (cost.value / 100);
            }
            overheadTotal += amount;
            overheadBreakdown.push({ name: cost.name, cost: amount });
        });

        // 3. Total Cost
        const totalCost = materialCost + overheadTotal;

        // 4. Suggested Price
        const margin = parseFloat(this.profitMargin) || 0;
        const profitAmount = totalCost * (margin / 100);
        const suggestedPrice = totalCost + profitAmount;

        this.totals = {
            material: materialCost,
            overhead: overheadTotal,
            totalCost: totalCost,
            suggestedPrice: suggestedPrice,
            recipeBreakdown: recipeBreakdown,
            overheadBreakdown: overheadBreakdown,
            profitAmount: profitAmount
        };
    },

    formatMoney(value) {
        return (parseFloat(value) || 0).toFixed(2);
    }
        }));
    });
</script>
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
@endsection
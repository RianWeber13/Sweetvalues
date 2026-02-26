@extends('layouts.app')

@section('content')
@php
    // Material cost per recipe
    $materialCost = 0;
    $recipeBreakdown = [];
    foreach ($product->recipes as $recipe) {
        if ($recipe->yield_quantity > 0) {
            $unitCost = $recipe->total_cost / $recipe->yield_quantity;
            $cost = $unitCost * $recipe->pivot->quantity;
            $materialCost += $cost;
            $recipeBreakdown[] = [
                'name'     => $recipe->name,
                'quantity' => $recipe->pivot->quantity,
                'unit'     => $recipe->yield_unit,
                'cost'     => $cost,
            ];
        }
    }

    // Overhead costs
    $overheadTotal = 0;
    $overheadBreakdown = [];
    foreach ($product->overheadCosts as $overhead) {
        if ($overhead->type === 'fixed') {
            $amount = $overhead->value;
        } else {
            $amount = $materialCost * ($overhead->value / 100);
        }
        $overheadTotal += $amount;
        $overheadBreakdown[] = [
            'name'  => $overhead->name,
            'type'  => $overhead->type,
            'value' => $overhead->value,
            'cost'  => $amount,
        ];
    }

    $totalCost = $materialCost + $overheadTotal;
    $profitAmount = $totalCost * ($product->profit_margin / 100);
    $suggestedPrice = $totalCost + $profitAmount;
@endphp

<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('products.edit', $product) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                    Editar
                </a>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                    Voltar
                </a>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 space-y-6">

                <!-- Recipes -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Receitas</h3>
                    @forelse($recipeBreakdown as $item)
                    <div class="flex justify-between py-1.5 border-b border-gray-100 last:border-0">
                        <div>
                            <span class="text-gray-800 font-medium">{{ $item['name'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($item['quantity'], 2, ',', '.') }} {{ $item['unit'] }})</span>
                        </div>
                        <span class="font-medium text-gray-700">R$ {{ number_format($item['cost'], 2, ',', '.') }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 italic">Nenhuma receita vinculada.</p>
                    @endforelse
                    <div class="flex justify-between pt-2 mt-1">
                        <span class="text-sm text-gray-600 font-semibold">Subtotal Receitas</span>
                        <span class="font-semibold text-gray-800">R$ {{ number_format($materialCost, 2, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Overhead Costs -->
                @if(count($overheadBreakdown) > 0)
                <div class="border-t pt-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Custos Indiretos</h3>
                    @foreach($overheadBreakdown as $item)
                    <div class="flex justify-between py-1.5 border-b border-gray-100 last:border-0">
                        <div>
                            <span class="text-gray-800 font-medium">{{ $item['name'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">
                                @if($item['type'] === 'fixed') (fixo) @else ({{ $item['value'] }}% sobre receitas) @endif
                            </span>
                        </div>
                        <span class="font-medium text-orange-600">+ R$ {{ number_format($item['cost'], 2, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <div class="flex justify-between pt-2 mt-1">
                        <span class="text-sm text-gray-600 font-semibold">Subtotal Custos Indiretos</span>
                        <span class="font-semibold text-orange-600">R$ {{ number_format($overheadTotal, 2, ',', '.') }}</span>
                    </div>
                </div>
                @endif

                <!-- Totals -->
                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-800 font-semibold">Custo Total</span>
                        <span class="font-bold text-gray-900">R$ {{ number_format($totalCost, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Margem de lucro ({{ $product->profit_margin }}%)</span>
                        <span class="font-medium text-green-600">+ R$ {{ number_format($profitAmount, 2, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Suggested Price -->
                <div class="bg-green-50 rounded-lg p-4 flex justify-between items-center border border-green-200">
                    <span class="text-green-800 font-bold text-lg">Preço Sugerido</span>
                    <span class="font-bold text-2xl text-green-700">R$ {{ number_format($suggestedPrice, 2, ',', '.') }}</span>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ __('Receitas Cadastradas') }}
                    </h2>
                    <a href="{{ route('recipes.create') }}"
                        class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Adicionar Receita') }}
                    </a>
                </div>

                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sucesso!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Rendimento
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Custo Total
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recipes as $recipe)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $recipe->name }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $recipe->yield_quantity }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap font-bold text-green-600">
                                        R$ {{ number_format($recipe->total_cost, 2, ',', '.') }}
                                    </p>
                                    <div class="text-xs text-gray-500 mt-1">
                                        @foreach($recipe->ingredients as $ingredient)
                                        <div>
                                            {{ $ingredient->pivot->quantity_used }} {{ $ingredient->unit }} de {{ $ingredient->name }}
                                            (R$ {{ number_format($ingredient->unit_cost * $ingredient->pivot->quantity_used, 2, ',', '.') }})
                                        </div>
                                        @endforeach
                                        @foreach($recipe->overheadCosts as $cost)
                                        <div class="text-gray-400">
                                            {{ $cost->name }}:
                                            {{ $cost->type === 'fixed' ? 'R$ ' . number_format($cost->value, 2, ',', '.') : $cost->value . '%' }}
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    Nenhuma receita cadastrada.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Ingredientes em Estoque</h1>
    <a href="{{ route('ingredients.create') }}"
        class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 transition">
        + Adicionar Novo
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-pink-600 text-white">
            <tr>
                <th class="p-3 border border-pink-700">Nome</th>
                <th class="p-3 border border-pink-700">Preço Compra</th>
                <th class="p-3 border border-pink-700">Quantidade</th>
                <th class="p-3 border border-pink-700">Custo por grama</th>
                <th class="p-3 border border-pink-700">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($ingredients as $ingredient)
            <tr class="hover:bg-gray-50">
                <td class="p-3 border border-gray-200">{{ $ingredient->name }}</td>
                <td class="p-3 border border-gray-200">R$ {{ number_format($ingredient->purchase_price, 2, ',', '.') }}
                </td>
                <td class="p-3 border border-gray-200">{{ $ingredient->package_size }} {{ $ingredient->unit }}</td>
                <td class="p-3 border border-gray-200">
                    {{-- Cálculo em tempo real: Preço / Tamanho --}}
                    R$ {{ number_format($ingredient->purchase_price / $ingredient->package_size, 4, ',', '.') }}
                </td>
                <td class="p-3 border border-gray-200">
                    <a href="{{ route('ingredients.edit', $ingredient->id) }}"
                        class="text-pink-600 hover:text-pink-800 font-semibold">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
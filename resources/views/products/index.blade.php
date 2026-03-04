@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Sucesso!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(!$category)
        {{-- TELA DE CATEGORIAS --}}
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Produtos</h2>
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 transition ease-in-out duration-150">
                Adicionar Novo Produto
            </a>
        </div>

        @php
        $icons = [
            'Cookies'        => '🍪',
            'Salgados'       => '🥐',
            'Doces de Festa' => '🍫',
            'Sobremesas'     => '🍮',
            'Bolos'          => '🎂',
        ];
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat]) }}"
                class="group flex flex-col items-center justify-center bg-white rounded-xl shadow-md hover:shadow-xl
                       border-2 border-transparent hover:border-pink-400 transition-all duration-200 cursor-pointer
                       h-44 p-6 text-center">
                <span class="text-5xl mb-3 group-hover:scale-110 transition-transform duration-200 inline-block">
                    {{ $icons[$cat] ?? '📦' }}
                </span>
                <span class="text-base font-semibold text-gray-700 group-hover:text-pink-600 leading-tight">
                    {{ $cat }}
                </span>
            </a>
            @endforeach
        </div>

        @else
        {{-- TELA DE LISTA DE PRODUTOS DA CATEGORIA --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('products.index') }}"
                class="flex items-center gap-1 text-gray-500 hover:text-pink-600 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="text-sm font-medium">Categorias</span>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $category }}</h2>
            <div class="ml-auto">
                <a href="{{ route('products.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 transition ease-in-out duration-150">
                    Adicionar Novo Produto
                </a>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custo Materiais</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Margem</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Sugerido</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">R$ {{ number_format($product->material_cost, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->profit_margin }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-green-600">
                                R$ {{ number_format($product->suggested_price, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('products.show', $product) }}" class="text-gray-600 hover:text-gray-900 mr-4">Visualizar</a>
                                <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Nenhum produto cadastrado nesta categoria.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

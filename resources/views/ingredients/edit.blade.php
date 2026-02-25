@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Ingrediente</h1>

    <form action="{{ route('ingredients.update', $ingredient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nome do Ingrediente:</label>
            <input type="text" name="name" value="{{ $ingredient->name }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Unidade de Medida:</label>
            <select name="unit" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500 bg-white">
                <option value="g" {{ $ingredient->unit == 'g' ? 'selected' : '' }}>g (Gramas)</option>
                <option value="ml" {{ $ingredient->unit == 'ml' ? 'selected' : '' }}>ml (Mililitros)</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Preço de Compra (R$):</label>
            <input type="number" name="purchase_price" step="0.01" value="{{ $ingredient->purchase_price }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Tamanho da Embalagem:</label>
            <input type="number" name="package_size" step="0.01" value="{{ $ingredient->package_size }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>

        <button type="submit"
            class="w-full bg-pink-600 text-white font-bold py-2 px-4 rounded hover:bg-pink-700 transition duration-200">
            Atualizar Ingrediente
        </button>
    </form>
</div>
@endsection
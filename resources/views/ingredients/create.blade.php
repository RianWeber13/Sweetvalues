@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Novo Ingrediente</h1>

    <form action="{{ route('ingredients.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nome do Ingrediente:</label>
            <input type="text" name="name" placeholder="Ex: Leite Condensado" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Quantidade de Ingrediente:</label>
                <input type="number" name="package_size" step="1" placeholder="Ex: 395" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Unidade de Medida:</label>
                <select name="unit" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500 bg-white">
                    <option value="g">g (Gramas)</option>
                    <option value="ml">ml (Mililitros)</option>
                    <option value="un">un (Unidade)</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Preço de Compra (R$):</label>
            <input type="text" name="purchase_price" step="0.01" placeholder="00,00" oninput="formatarMoeda(this)" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('ingredients.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit"
                class="bg-pink-600 text-white font-bold py-2 px-4 rounded hover:bg-pink-700 transition duration-200">
                Salvar Ingrediente
            </button>
        </div>
    </form>
</div>
@endsection
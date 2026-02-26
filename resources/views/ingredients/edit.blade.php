@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Ingrediente</h1>

    <form action="{{ route('ingredients.update', $ingredient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nome do Ingrediente:</label>
            <input type="text" name="name" value="{{ old('name', $ingredient->name) }}" placeholder="Ex: Leite Condensado" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
            @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Quantidade de Ingrediente:</label>
                <input type="number" name="package_size" step="1" value="{{ old('package_size', $ingredient->package_size) }}" placeholder="Ex: 395" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
                @error('package_size')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Unidade de Medida:</label>
                <select name="unit" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500 bg-white">
                    <option value="g"  {{ old('unit', $ingredient->unit) == 'g'  ? 'selected' : '' }}>g (Gramas)</option>
                    <option value="ml" {{ old('unit', $ingredient->unit) == 'ml' ? 'selected' : '' }}>ml (Mililitros)</option>
                    <option value="un" {{ old('unit', $ingredient->unit) == 'un' ? 'selected' : '' }}>un (Unidade)</option>
                </select>
                @error('unit')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Preço de Compra (R$):</label>
            <input type="text" name="purchase_price" placeholder="00,00"
                value="{{ old('purchase_price', number_format($ingredient->purchase_price, 2, ',', '.')) }}"
                oninput="formatarMoeda(this)" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
            @error('purchase_price')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('ingredients.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit"
                class="bg-pink-600 text-white font-bold py-2 px-4 rounded hover:bg-pink-700 transition duration-200">
                Atualizar Ingrediente
            </button>
        </div>
    </form>
</div>
@endsection

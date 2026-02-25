@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Adicionar Novo Custo Indireto / Despesa') }}
        </h2>
    </div>

    <form method="POST" action="{{ route('overhead_costs.store') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">{{ __('Nome da Despesa') }}</label>
            <input id="name"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500"
                type="text" name="name" value="{{ old('name') }}" required autofocus />
            @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Type -->
        <div class="mb-4">
            <label for="type" class="block text-gray-700 font-bold mb-2">{{ __('Tipo de Custo') }}</label>
            <select id="type" name="type"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
                <option value="fixed" {{ old('type')=='fixed' ? 'selected' : '' }}>Valor Fixo (R$)</option>
                <option value="percentage" {{ old('type')=='percentage' ? 'selected' : '' }}>Porcentagem (%)</option>
            </select>
            @error('type')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Value -->
        <div class="mb-6">
            <label for="value" class="block text-gray-700 font-bold mb-2">{{ __('Valor') }}</label>
            <input id="value"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500"
                type="number" step="0.01" name="value" value="{{ old('value') }}" required />
            @error('value')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <a href="{{ route('overhead_costs.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                {{ __('Cancelar') }}
            </a>
            <button type="submit"
                class="bg-pink-600 text-white font-bold py-2 px-4 rounded hover:bg-pink-700 transition duration-200">
                {{ __('Salvar Custo') }}
            </button>
        </div>
    </form>
</div>
@endsection
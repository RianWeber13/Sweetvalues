@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Usuário</h1>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nome:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Ex: Maria Silva" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
            @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">E-mail:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Ex: maria@email.com" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
            @error('email')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t pt-4 mt-4">
            <p class="text-sm text-gray-500 mb-3">Deixe os campos de senha em branco para mantê-la inalterada.</p>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nova Senha:</label>
                <input type="password" name="password" placeholder="Mínimo 8 caracteres"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
                @error('password')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Confirmar Nova Senha:</label>
                <input type="password" name="password_confirmation" placeholder="Repita a nova senha"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit"
                class="bg-pink-600 text-white font-bold py-2 px-4 rounded hover:bg-pink-700 transition duration-200">
                Atualizar Usuário
            </button>
        </div>
    </form>
</div>
@endsection

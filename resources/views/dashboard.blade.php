@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- HEADER COM LOGO E BOAS-VINDAS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col md:flex-row items-center gap-8">
            <img src="{{ asset('logo.jpeg') }}" alt="Sweet Values" class="h-28 w-auto rounded-xl object-contain">
            <div>
                <h1 class="text-3xl font-bold text-[#5D3A2D]">Bem-vindo, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-500 mt-2 text-sm leading-relaxed">
                    Este é o painel de controle do <strong>Sweet Values</strong> — sua plataforma de gestão de custos
                    e precificação de produtos artesanais. Gerencie ingredientes, receitas e calcule o preço ideal
                    para cada produto.
                </p>
                <p class="text-xs text-gray-400 mt-3">
                    {{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
                </p>
            </div>
        </div>

        {{-- CARDS DE ESTATÍSTICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('ingredients.index') }}"
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center
                       hover:shadow-md hover:border-pink-200 transition-all duration-200 group">
                <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center mb-3 group-hover:bg-pink-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-pink-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                    </svg>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ $stats['ingredientes'] }}</span>
                <span class="text-sm text-gray-500 mt-1">Ingredientes</span>
            </a>

            <a href="{{ route('recipes.index') }}"
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center
                       hover:shadow-md hover:border-pink-200 transition-all duration-200 group">
                <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center mb-3 group-hover:bg-amber-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ $stats['receitas'] }}</span>
                <span class="text-sm text-gray-500 mt-1">Receitas</span>
            </a>

            <a href="{{ route('products.index') }}"
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center
                       hover:shadow-md hover:border-pink-200 transition-all duration-200 group">
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ $stats['produtos'] }}</span>
                <span class="text-sm text-gray-500 mt-1">Produtos</span>
            </a>

            <a href="{{ route('users.index') }}"
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center
                       hover:shadow-md hover:border-pink-200 transition-all duration-200 group">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-3 group-hover:bg-blue-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ $stats['usuarios'] }}</span>
                <span class="text-sm text-gray-500 mt-1">Usuários</span>
            </a>
        </div>

        {{-- ATALHOS RÁPIDOS + ÚLTIMO PRODUTO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Atalhos Rápidos --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-4">Ações rápidas</h2>
                <div class="space-y-3">
                    <a href="{{ route('ingredients.create') }}"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-pink-50 transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-pink-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 group-hover:text-pink-600">Novo Ingrediente</p>
                            <p class="text-xs text-gray-400">Cadastrar um novo insumo</p>
                        </div>
                    </a>

                    <a href="{{ route('recipes.create') }}"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-amber-50 transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 group-hover:text-amber-600">Nova Receita</p>
                            <p class="text-xs text-gray-400">Criar uma nova receita com ingredientes</p>
                        </div>
                    </a>

                    <a href="{{ route('products.create') }}"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 group-hover:text-green-600">Novo Produto</p>
                            <p class="text-xs text-gray-400">Precificar um produto com receitas e custos</p>
                        </div>
                    </a>

                    <a href="{{ route('overhead_costs.index') }}"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 group-hover:text-gray-600">Custos Fixos</p>
                            <p class="text-xs text-gray-400">Gerenciar custos indiretos e overhead</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Último Produto Cadastrado --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-4">Último produto cadastrado</h2>

                @if($produtoMaisRecente)
                <div class="bg-gradient-to-br from-pink-50 to-amber-50 rounded-xl p-5 border border-pink-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-lg font-bold text-[#5D3A2D]">{{ $produtoMaisRecente->name }}</p>
                            @if($produtoMaisRecente->category)
                            <span class="inline-block mt-1 px-2 py-0.5 bg-pink-100 text-pink-700 text-xs rounded-full font-medium">
                                {{ $produtoMaisRecente->category }}
                            </span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400">{{ $produtoMaisRecente->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <p class="text-xs text-gray-400">Custo</p>
                            <p class="text-sm font-bold text-gray-700 mt-0.5">
                                R$ {{ number_format($produtoMaisRecente->material_cost, 2, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <p class="text-xs text-gray-400">Margem</p>
                            <p class="text-sm font-bold text-gray-700 mt-0.5">
                                {{ $produtoMaisRecente->profit_margin }}%
                            </p>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <p class="text-xs text-gray-400">Preço</p>
                            <p class="text-sm font-bold text-green-600 mt-0.5">
                                R$ {{ number_format($produtoMaisRecente->suggested_price, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('products.show', $produtoMaisRecente) }}"
                        class="mt-4 block text-center text-xs text-pink-600 hover:text-pink-800 font-medium">
                        Ver detalhes →
                    </a>
                </div>
                @else
                <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                    </svg>
                    <p class="text-sm">Nenhum produto cadastrado ainda</p>
                    <a href="{{ route('products.create') }}" class="mt-2 text-xs text-pink-500 hover:underline">Criar primeiro produto</a>
                </div>
                @endif
            </div>
        </div>

        {{-- DICA --}}
        <div class="bg-[#5D3A2D] bg-opacity-5 border border-[#5D3A2D] border-opacity-20 rounded-xl p-5 flex items-start gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#5D3A2D] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.354a15.055 15.055 0 0 1-4.5 0M12 3v1.5M3.75 12H2.25m1.5 0H3m13.5 0H21m-1.5 0H18M12 20.25v1.5M6.879 5.121l-1.06-1.06-1.061 1.06 1.06 1.061L6.88 5.121ZM18.182 5.121l1.06-1.06 1.061 1.06-1.06 1.061-1.061-1.061ZM6.879 18.879l-1.06 1.06-1.061-1.06 1.06-1.061 1.061 1.061ZM18.182 18.879l1.06 1.06 1.061-1.06-1.06-1.061-1.061 1.061Z" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-[#5D3A2D]">Dica de precificação</p>
                <p class="text-sm text-[#5D3A2D] text-opacity-80 mt-1">
                    Para calcular o preço ideal, cadastre todos os ingredientes com seus custos, monte a receita com as quantidades corretas e depois crie o produto associando as receitas e os custos fixos. O sistema calculará o preço sugerido automaticamente.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection

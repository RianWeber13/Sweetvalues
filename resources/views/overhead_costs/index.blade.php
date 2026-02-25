@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestão de Custos e Despesas') }}
    </h2>
    <a href="{{ route('overhead_costs.create') }}"
        class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ __('Adicionar Novo Custo') }}
    </a>
</div>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($overheadCosts as $cost)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cost->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap capitalize">
                        @if($cost->type == 'fixed') Fixo @else Porcentagem @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($cost->type == 'fixed')
                        R$ {{ number_format($cost->value, 2, ',', '.') }}
                        @else
                        {{ $cost->value }}%
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('overhead_costs.edit', $cost) }}"
                            class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</a>
                        <form action="{{ route('overhead_costs.destroy', $cost) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Tem certeza que deseja excluir?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhum custo cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
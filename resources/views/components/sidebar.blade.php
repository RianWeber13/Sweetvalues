<div class="h-screen w-64 bg-white border-r border-gray-200 fixed left-0 top-0 flex flex-col hidden md:flex z-50">
    <!-- Brand / Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-200">
        <div class="flex items-center gap-2 text-pink-600 font-bold text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12" />
            </svg>
            <span>Sweet Values</span>
        </div>
    </div>

    <!-- Navigation List -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Dashboard
                </div>
                <a href="#"
                    class="flex items-center gap-3 px-6 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Início</span>
                </a>
            </li>

            <!-- Gestão de Insumos -->
            <li class="mt-4">
                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Gestão de Insumos
                </div>
                <!-- Ingredientes (Index) -->
                <a href="{{ route('ingredients.index') }}"
                    class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('ingredients.index') ? 'bg-pink-50 text-pink-600 border-r-4 border-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                    </svg>
                    <span>Ingredientes</span>
                </a>
                <!-- Novo Ingrediente -->
                <a href="{{ route('ingredients.create') }}"
                    class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('ingredients.create') ? 'bg-pink-50 text-pink-600 border-r-4 border-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Novo Ingrediente</span>
                </a>
            </li>

            <!-- Gestão de Produtos -->
            <li class="mt-4">
                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Gestão de Produtos
                </div>
                <!-- Receitas -->
                <a href="{{ route('recipes.index') }}"
                    class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('recipes.*') ? 'bg-pink-50 text-pink-600 border-r-4 border-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span>Receitas</span>
                </a>

                <!-- Produtos -->
                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('products.*') ? 'bg-pink-50 text-pink-600 border-r-4 border-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <span>Produtos</span>
                </a>
                <!-- Configurações de Custos -->
                <a href="{{ route('overhead_costs.index') }}"
                    class="flex items-center gap-3 px-6 py-3 {{ request()->routeIs('overhead_costs.*') ? 'bg-pink-50 text-pink-600 border-r-4 border-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Configurações de Custos</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Configurações (Rodapé) -->
    <div class="border-t border-gray-200 p-4">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('users.index') }}"
                    class="flex items-center gap-3 px-2 py-2 {{ request()->routeIs('users.*') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600' }} rounded-md transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <span>Usuários</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center gap-3 px-2 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        <span>Sair</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
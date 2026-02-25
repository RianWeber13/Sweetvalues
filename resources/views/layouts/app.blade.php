<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Values - Gestão de Precificação</title>

    <!-- Option 1: Using Vite (Recommended for production/development if npm run dev is running) -->
    <!-- Option 1: Using Vite (Commented out because npm is not installed) -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <!-- Option 2: CDN Backstop (In case user isn't running npm run dev) -->
    <!-- Remove this if you strictly use Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar for sidebar if needed */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- Mobile Header -->
    <div
        class="md:hidden flex items-center justify-between bg-white border-b border-gray-200 px-4 py-3 fixed w-full top-0 z-40">
        <div class="flex items-center gap-2 text-pink-600 font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5 1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12" />
            </svg>
            <span>Sweet Values</span>
        </div>
        <button id="mobile-menu-btn" class="text-gray-600 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>

    <!-- Mobile Sidebar (Overlay) -->
    <div id="mobile-sidebar" class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 hidden md:hidden">
        <div class="absolute left-0 top-0 bottom-0 w-64 bg-white shadow-xl transform transition-transform duration-300 -translate-x-full"
            id="mobile-sidebar-content">
            <!-- Close Button -->
            <div class="flex justify-end p-4">
                <button id="close-sidebar-btn" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Include the sidebar links content here again or refactor to include view. For simplicity, duplicating visual structure or handling via include if component allows. 
                 To keep it simple, I'll allow the main sidebar component to handle the inner content if I include it, but the component has 'hidden md:flex' classes. 
                 Alternative: The component should be flexible. 
                 Let's fix the component first to be agnostic or handle visibility via parent. 
            -->

            <!-- Cloning the sidebar content for mobile for now to ensure distinct mobile behavior without complex component logic -->
            <div class="px-2">
                @include('components.sidebar', ['mobile' => true])
                <!-- Note: The component has 'hidden md:flex' which will hide it. I need to override this or create a separate mobile sidebar structure. 
                      Actually, simpler approach: Remove 'hidden md:flex' from the component and wrapper, and control visibility in the layout.
                 -->
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="md:ml-64 min-h-screen pt-16 md:pt-0 transition-all duration-300">
        <div class="p-6 md:p-8">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm"
                role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        // Simple Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('mobile-sidebar');
        const content = document.getElementById('mobile-sidebar-content');
        const closeBtn = document.getElementById('close-sidebar-btn');

        function openSidebar() {
            sidebar.classList.remove('hidden');
            // Small timeout to allow display:block to apply before transition
            setTimeout(() => {
                content.classList.remove('-translate-x-full');
            }, 10);
        }

        function closeSidebar() {
            content.classList.add('-translate-x-full');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 300);
        }

        btn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        sidebar.addEventListener('click', (e) => {
            if (e.target === sidebar) closeSidebar();
        });
    </script>
    @stack('scripts')
</body>

</html>
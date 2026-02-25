<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sweet Values</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-[#FDF8F5] min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('logo.jpeg') }}" alt="Sweet Values Logo" class="max-w-[300px] h-auto">
        </div>

        <h2 class="text-2xl font-bold text-[#5D3A2D] text-center mb-6">Bem-vindo de volta!</h2>

        <!-- Error Feedback -->
        @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p class="font-bold">Atenção</p>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <!-- Heroicon name: solid/mail -->
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="pl-10 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#5D3A2D] focus:border-transparent transition-colors duration-200">
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4" x-data="{ show: false }">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <!-- Heroicon name: solid/lock-closed -->
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required
                        autocomplete="current-password"
                        class="pl-10 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#5D3A2D] focus:border-transparent transition-colors duration-200">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" @click="show = !show">
                        <!-- Heroicon name: solid/eye -->
                        <svg x-show="!show" class="h-5 w-5 text-gray-400 hover:text-gray-600"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <!-- Heroicon name: solid/eye-off -->
                        <svg x-show="show" class="h-5 w-5 text-gray-400 hover:text-gray-600"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" style="display: none;">
                            <path fill-rule="evenodd"
                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                clip-rule="evenodd" />
                            <path
                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.064 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                        </svg>
                    </div>
                </div>
                <div class="flex justify-end mt-1">
                    <a href="#" class="text-xs text-gray-500 hover:text-[#5D3A2D]">Esqueci minha senha</a>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="block mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-[#5D3A2D] shadow-sm focus:border-[#5D3A2D] focus:ring focus:ring-[#5D3A2D] focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Lembrar de mim</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-4">
                <button type="submit"
                    class="w-full bg-[#5D3A2D] hover:bg-[#4a2e24] text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200 uppercase tracking-wider text-sm">
                    Entrar
                </button>
            </div>
        </form>
    </div>
</body>

</html>
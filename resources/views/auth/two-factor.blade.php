<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação - Sweet Values</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#FDF8F5] min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('logo.jpeg') }}" alt="Sweet Values Logo" class="max-w-[300px] h-auto">
        </div>

        <h2 class="text-2xl font-bold text-[#5D3A2D] text-center mb-2">Verificação em dois passos</h2>
        <p class="text-sm text-gray-500 text-center mb-6">
            Enviamos um código de 6 dígitos para o seu e-mail.<br>Ele expira em <strong>10 minutos</strong>.
        </p>

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

        <form method="POST" action="{{ route('two-factor.store') }}">
            @csrf

            <div class="mb-6">
                <label for="code" class="block text-gray-700 text-sm font-bold mb-2">
                    Código de verificação
                </label>
                <input
                    id="code"
                    type="text"
                    name="code"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    autocomplete="one-time-code"
                    required
                    autofocus
                    class="w-full px-3 py-3 border border-gray-300 rounded text-center text-2xl tracking-widest
                           focus:outline-none focus:ring-2 focus:ring-[#5D3A2D] focus:border-transparent
                           transition-colors duration-200"
                    placeholder="______"
                >
            </div>

            <button type="submit"
                class="w-full bg-[#5D3A2D] hover:bg-[#4a2e24] text-white font-bold py-3 px-4 rounded
                       focus:outline-none focus:shadow-outline transition duration-200 uppercase tracking-wider text-sm">
                Verificar
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-[#5D3A2D]">
                Voltar ao login
            </a>
        </div>
    </div>
</body>

</html>

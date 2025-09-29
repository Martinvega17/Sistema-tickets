<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Tickets Pepsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media (max-width: 768px) {
            .mobile-bg {
                background: linear-gradient(rgba(0, 24, 82, 0.8), rgba(0, 24, 82, 0.8)), url('{{ asset('img/Loginhelppeople.png') }}');
                background-size: cover;
                background-position: center;
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col lg:flex-row">
    <!-- Columna izquierda (100% en móvil, 30% en desktop) -->
    <div
        class="w-full lg:w-[30%] min-h-screen flex items-center justify-center bg-[#001852] mobile-bg lg:mobile-bg-none">
        <div class="max-w-md w-full p-6 sm:p-8">
            <!-- Logo -->
            <div class="text-center mb-6 sm:mb-8">
                <img src="{{ asset('img/logo.png') }}" class="w-20 sm:w-32 mx-auto mb-4">
                <h1 class="text-xl sm:text-3xl font-bold text-white">Sistema de Tickets</h1>
                <p class="text-white mt-2 text-sm sm:text-base">Ingresa a tu cuenta</p>
            </div>

            <!-- Errores -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="numero_nomina" class="block text-sm font-medium text-white mb-2">Usuario</label>
                    <input type="text" id="numero_nomina" name="numero_nomina" value="{{ old('numero_nomina') }}"
                        required autofocus
                        class="w-full px-3 sm:px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93] text-sm sm:text-base">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-white mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 sm:px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93] text-sm sm:text-base">
                </div>

                <button type="submit"
                    class="w-full bg-[#004B93] text-white py-2 sm:py-3 px-4 rounded-md hover:bg-[#D50032] transition text-sm sm:text-base">
                    Iniciar Sesión
                </button>
            </form>

            <div class="mt-4 sm:mt-6 text-center">
                <p class="text-xs sm:text-sm text-white">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="font-medium text-white hover:text-[#D50032]">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Columna derecha (oculta en móvil, 70% en desktop) -->
    <div class="hidden lg:flex w-[70%] h-screen relative">
        <img src="{{ asset('img/Loginhelppeople.png') }}" class="w-full h-full object-cover object-bottom">

        <div class="absolute bottom-6 left-0 right-0 text-center text-white text-sm">
            © {{ date('Y') }} PepsiCo - Field Services
        </div>
    </div>

    <!-- Footer para móviles -->
    <div class="lg:hidden py-4 bg-[#001852] text-center text-white text-xs">
        © {{ date('Y') }} PepsiCo - Field Services
    </div>
</body>

</html>

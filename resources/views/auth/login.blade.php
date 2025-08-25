<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Tickets Pepsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex">
    <!-- Columna izquierda (30%) -->
    <div class="w-[30%] h-screen flex items-center justify-center bg-[#001852]">
        <div class="max-w-md w-full p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('img/logo.png') }}" class="w-120 mx-auto mb-4">
                <h1 class="text-3xl font-bold text-white">Sistema de Tickets</h1>
                <p class="text-white mt-2">Ingresa a tu cuenta</p>
            </div>

            <!-- Errores -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
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
                        required autofocus class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-white mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <button type="submit"
                    class="w-full bg-[#004B93] text-white py-3 px-4 rounded-md hover:bg-[#D50032] transition">
                    Iniciar Sesión
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-white">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="font-medium text-white hover:text-[#D50032]">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Columna derecha (70%) -->
    <div class="hidden lg:flex w-[70%] h-screen relative">
        <img src="{{ asset('img/Loginhelppeople.png') }}" class="w-full h-full object-cover object-bottom">

        <div class="absolute bottom-6 left-0 right-0 text-center text-white text-sm">
            © {{ date('Y') }} PepsiCo - Field Services
        </div>
    </div>
</body>

</html>

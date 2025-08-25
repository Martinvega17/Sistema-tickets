<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Tickets Pepsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex">
    <!-- Columna izquierda -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-white">
        <div class="max-w-md w-full p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('img/pepsi-logo.png') }}" class="w-20 mx-auto mb-4">
                <h1 class="text-3xl font-bold text-[#004B93]">Sistema de Tickets</h1>
                <p class="text-gray-600 mt-2">Ingresa a tu cuenta</p>
            </div>

            <!-- Formulario -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="numero_nomina" class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
                    <input type="text" id="numero_nomina" name="numero_nomina" value="{{ old('numero_nomina') }}"
                        required autofocus class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <button type="submit"
                    class="w-full bg-[#004B93] text-white py-3 px-4 rounded-md hover:bg-[#D50032] transition">
                    Iniciar Sesión
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="font-medium text-[#004B93] hover:text-[#D50032]">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Columna derecha -->
    <div
        class="hidden lg:flex w-1/2 bg-gradient-to-br from-[#004B93] to-[#003366] items-center justify-center relative">
        <img src="{{ asset('img/pepsi-wall.png') }}" class="max-w-md opacity-90">
        <div class="absolute bottom-6 text-white text-sm">© {{ date('Y') }} PepsiCo - Field Services</div>
    </div>
</body>

</html>

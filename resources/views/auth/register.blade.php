<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema de Tickets Pepsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex">
    <!-- Columna izquierda -->
    <div class="w-full lg:w-[30%] flex items-center justify-center bg-[#001852]">
        <div class="max-w-md w-full p-8">
            <!-- Logo y título -->
            <div class="text-center mb-8">
                <img src="{{ asset('img/logo.png') }}" class="w-2xl mx-auto mb-4">
                <h1 class="text-3xl font-bold text-white">Sistema de Tickets</h1>
                <p class="text-white mt-2">Crea tu cuenta de empleado</p>
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

            <!-- Formulario de registro -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-white mb-2">Nombre completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <div class="mb-4">
                    <label for="numero_nomina" class="block text-sm font-medium text-white mb-2">ID Empleado</label>
                    <input type="text" id="numero_nomina" name="numero_nomina" value="{{ old('numero_nomina') }}"
                        required class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white mb-2">Correo
                        electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-white mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-white mb-2">Confirmar
                        contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#004B93]">
                </div>

                <button type="submit"
                    class="w-full bg-[#004B93] text-white py-3 px-4 rounded-md hover:bg-[#D50032] transition">
                    Registrarse
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-white">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="font-medium text-[#004B93] hover:text-[#D50032]">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Columna derecha -->
    <div class="hidden lg:flex w-[70%] h-screen relative">
        <img src="{{ asset('img/Loginhelppeople.png') }}" class="w-full h-full object-cover object-bottom">
        <div class="absolute bottom-6 left-0 right-0 text-center text-white text-sm">
            © {{ date('Y') }} PepsiCo - Field Services
        </div>
    </div>
</body>

</html>

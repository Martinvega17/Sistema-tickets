<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema de Tickets Pepsi</title>
    <!-- TailwindCSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pepsi-blue': '#004B93',
                        'pepsi-red': '#D50032',
                        'pepsi-white': '#FFFFFF',
                    }
                }
            }
        }
    </script>
    <style>
        .pepsi-blue {
            background-color: #004B93;
        }

        .pepsi-red {
            background-color: #D50032;
        }

        .pepsi-white {
            background-color: #FFFFFF;
        }

        .text-pepsi-blue {
            color: #004B93;
        }

        .text-pepsi-red {
            color: #D50032;
        }

        .border-pepsi-blue {
            border-color: #004B93;
        }

        .border-pepsi-red {
            border-color: #D50032;
        }
    </style>
</head>

<body class="bg-[#001852] min-h-screen flex items-center justify-center py-8">
    <div class="max-w-4xl w-full mx-4">
        <!-- Logo Pepsi -->
        <div class="text-center mb-8">
            <div class="mb-4">
                <div class="w-80 h-16 justify-center items-center mx-auto mb-20">
                    <img src="{{ asset('img/logo.png') }}" class="w-120 mx-auto mb-4 ">
                </div>
            </div>
            <h1 class="text-3xl font-bold text-[#004B93]">Sistema de Tickets</h1>
            <p class="text-gray-600 mt-2">Crea tu cuenta de empleado</p>
        </div>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
            <div class="px-8 py-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Campos de usuario -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent"
                                placeholder="Juan">
                        </div>
                        <div>
                            <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">Apellidos
                                *</label>
                            <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent"
                                placeholder="Pérez">
                        </div>
                        <div>
                            <label for="numero_nomina" class="block text-sm font-medium text-gray-700 mb-2">ID Asociado
                                *</label>
                            <input type="text" id="numero_nomina" name="numero_nomina"
                                value="{{ old('numero_nomina') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent"
                                placeholder="EMP001">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo
                                Electrónico *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent"
                                placeholder="tu.correo@gepp.com">
                        </div>
                        <!-- Select de Región -->
                        <div>
                            <label for="region_id" class="block text-sm font-medium text-gray-700 mb-2">Región *</label>
                            <select id="region_id" name="region_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent">
                                <option value="">Selecciona una región</option>
                                @foreach ($regiones as $region)
                                    <option value="{{ $region->id }}"
                                        {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Select de CEDIS -->
                        <div>
                            <label for="cedis_id" class="block text-sm font-medium text-gray-700 mb-2">CEDIS *</label>
                            <select id="cedis_id" name="cedis_id" required data-old="{{ old('cedis_id') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent">
                                <option value="">Selecciona un CEDIS</option>
                                @if (old('region_id'))
                                    @foreach ($todosCedis->where('region_id', old('region_id')) as $cedis)
                                        <option value="{{ $cedis->id }}"
                                            {{ old('cedis_id') == $cedis->id ? 'selected' : '' }}>
                                            {{ $cedis->nombre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent"
                                placeholder="+52 55 1234 5678">
                        </div>





                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña
                                *</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent"
                                placeholder="••••••••">
                        </div>
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:border-transparent"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="terms" name="terms" required
                                class="h-4 w-4 text-[#004B93] focus:ring-[#004B93] border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                Acepto los <a href="#" class="text-[#004B93] hover:text-[#D50032]">términos y
                                    condiciones</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#004B93] text-white py-3 px-4 rounded-md hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004B93] focus:ring-offset-2 transition duration-200">
                        Crear Cuenta
                    </button>
                </form>
            </div>

            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="font-medium text-[#004B93] hover:text-[#D50032]">Inicia
                        sesión aquí</a>
                </p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} PepsiCo. Todos los derechos reservados.</p>
        </div>
    </div>

    <!-- Incluir el archivo JavaScript externo -->
    <script src="{{ asset('js/register.js') }}"></script>
</body>

</html>

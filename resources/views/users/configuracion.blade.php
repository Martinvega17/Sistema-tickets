@if (in_array($userRole, [1, 2, 3]))
    <!-- Mostrar sección de administración solo para roles 1,2,3 -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-pepsi-blue mb-6">Herramientas de Administración</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if (in_array($userRole, [1, 2, 3]))
                <a href="{{ route('usuarios.index') }}"
                    class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-pepsi-blue rounded-lg flex items-center justify-center mr-4">
                            👥
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Gestión de Usuarios</h3>
                            <p class="text-gray-600">Administrar usuarios del sistema</p>
                        </div>
                    </div>
                </a>
            @endif

            @if (in_array($userRole, [1, 2]))
                <a href="{{ route('configuracion') }}"
                    class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-pepsi-red rounded-lg flex items-center justify-center mr-4">
                            ⚙️
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Configuración</h3>
                            <p class="text-gray-600">Configuración del sistema</p>
                        </div>
                    </div>
                </a>
            @endif
        </div>
    </div>
@endif

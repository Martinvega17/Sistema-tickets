@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-pepsi-blue">
        Hola, {{ Auth::user()->nombre }}!
        @if(Auth::user()->rol_id == 1)
            <span class="text-sm text-pepsi-red">(Administrador)</span>
        @elseif(Auth::user()->rol_id == 2)
            <span class="text-sm text-pepsi-blue">(Supervisor)</span>
        @elseif(Auth::user()->rol_id == 3)
            <span class="text-sm text-green-600">(Coordinador)</span>
        @endif
    </h1>
    <p class="text-gray-600 mt-2">Bienvenido al sistema de tickets de Pepsi</p>
</div>

<!-- Contenido para todos -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Tarjeta Helpdesk - Para todos -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-200">
        <div class="p-6">
            <!-- Contenido común -->
        </div>
    </div>
</div>

<!-- Sección solo para Admin, Supervisor y Coordinador -->
@if(in_array(Auth::user()->rol_id, [1, 2, 3]))
<div class="mt-8">
    <h2 class="text-2xl font-bold text-pepsi-blue mb-6">Gestión de Usuarios</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('usuarios.index') }}" class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-pepsi-blue rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Gestión de Usuarios</h3>
                    <p class="text-gray-600">Administra usuarios del sistema</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endif

<!-- Sección solo para Admin y Supervisor -->
@if(in_array(Auth::user()->rol_id, [1, 2]))
<div class="mt-8">
    <h2 class="text-2xl font-bold text-pepsi-blue mb-6">Gestión de CEDIS</h2>
    <!-- Contenido específico -->
</div>
@endif
@endsection
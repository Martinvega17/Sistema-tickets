@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-pepsi-blue">Hola, {{ Auth::user()->nombre }} !</h1>
        <p class="text-gray-600 mt-2">Estas son tus aplicaciones disponibles</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Tarjeta Conocimiento -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-pepsi-blue rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-pepsi-blue">Conocimiento</h3>
                </div>
                <p class="text-gray-600 mb-4">Documenta los artículos que estarán disponibles para la autogestión de tus
                    usuarios.</p>
                <button class="px-4 py-2 bg-pepsi-blue text-white rounded-lg hover:bg-pepsi-dark-blue transition-colors">
                    Acceder
                </button>
            </div>
        </div>

        <!-- Tarjeta Helpdesk -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-pepsi-red rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-pepsi-red">Helpdesk</h3>
                </div>
                <p class="text-gray-600 mb-4">Maneja los tipos de trabajo de su compañía y detalle a sus clientes con
                    soluciones aisladas.</p>
                <button class="px-4 py-2 bg-pepsi-red text-white rounded-lg hover:bg-red-700 transition-colors">
                    Acceder
                </button>
            </div>
        </div>

        <!-- Tarjeta Self Service -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-pepsi-light-blue rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-pepsi-light-blue">Self Service</h3>
                </div>
                <p class="text-gray-600 mb-4">Autogestiona todas las solicitudes y consulta la librería de soluciones.</p>
                <!-- En la tarjeta Self Service -->
                <button onclick="window.location.href='{{ route('self-service') }}'"
                    class="px-4 py-2 bg-pepsi-light-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Acceder
                </button>
            </div>
        </div>
    </div>
@endsection

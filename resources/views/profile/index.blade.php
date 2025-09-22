@php
    $rolId = auth()->user()->rol_id;
    $isAdminDashboard = in_array($rolId, [1, 2]); // Admin y Supervisor
    $layout = $isAdminDashboard ? 'layouts.admin' : 'layouts.app';
    $section = $isAdminDashboard ? 'content.dashboard' : 'content';
@endphp

@extends($layout)

@section($section)
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-center items-center min-h-96">
            <div class="text-center">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-gray-600">Cargando perfil de usuario...</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Redirigir a la página de datos personales
            window.location.href = '{{ route('profile.personal') }}';
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar ya está incluido en layouts.app -->

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Header -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div>
                        <h1 class="h2">Base de Conocimiento</h1>
                        <p class="text-muted">Encuentra soluciones a problemas comunes</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group me-3" style="width: 300px;">
                            <span class="input-group-text bg-transparent">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Buscar en conocimiento...">
                        </div>
                        <div class="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Martín&background=0066CC&color=fff" alt="Usuario"
                                class="rounded-circle" width="40" height="40">
                        </div>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="fw-medium me-3">Filtrar por:</span>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm active">Todos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm">Soporte Técnico</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm">Software</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm">Hardware</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm">Redes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Artículos destacados -->
                <div class="mb-4">
                    <h2 class="h4 mb-3">Artículos Destacados</h2>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-primary">Software</span>
                                        <i class="far fa-bookmark text-muted"></i>
                                    </div>
                                    <h5 class="card-title">Cómo resetear la contraseña de Windows</h5>
                                    <p class="card-text text-muted small">Guía paso a paso para recuperar acceso a equipos
                                        con Windows cuando se ha olvidado la contraseña.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted small">
                                            <i class="far fa-eye me-1"></i> 245
                                            <i class="far fa-thumbs-up ms-3 me-1"></i> 89%
                                        </div>
                                        <small class="text-muted">Actualizado: 12/05/2023</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-danger">Urgente</span>
                                        <i class="far fa-bookmark text-muted"></i>
                                    </div>
                                    <h5 class="card-title">Solución a error de conexión de red</h5>
                                    <p class="card-text text-muted small">Procedimiento para resolver problemas comunes de
                                        conectividad en la red corporativa.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted small">
                                            <i class="far fa-eye me-1"></i> 189
                                            <i class="far fa-thumbs-up ms-3 me-1"></i> 94%
                                        </div>
                                        <small class="text-muted">Actualizado: 05/06/2023</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-success">Hardware</span>
                                        <i class="far fa-bookmark text-muted"></i>
                                    </div>
                                    <h5 class="card-title">Configuración de impresoras HP</h5>
                                    <p class="card-text text-muted small">Instalación y configuración de impresoras de la
                                        serie HP LaserJet en la red de Pepsi.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted small">
                                            <i class="far fa-eye me-1"></i> 312
                                            <i class="far fa-thumbs-up ms-3 me-1"></i> 91%
                                        </div>
                                        <small class="text-muted">Actualizado: 18/04/2023</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Todos los artículos -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Todos los Artículos</h2>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Categoría</th>
                                        <th>Visitas</th>
                                        <th>Rating</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-medium">Cómo acceder al VPN corporativo</td>
                                        <td><span class="badge bg-info">Redes</span></td>
                                        <td>156</td>
                                        <td>
                                            <i class="fas fa-star text-warning"></i>
                                            <span class="ms-1">4.8</span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                            <a href="#" class="btn btn-sm btn-outline-success">Editar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Instalación de SAP GUI</td>
                                        <td><span class="badge bg-purple">Software</span></td>
                                        <td>278</td>
                                        <td>
                                            <i class="fas fa-star text-warning"></i>
                                            <span class="ms-1">4.6</span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                            <a href="#" class="btn btn-sm btn-outline-success">Editar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Solución a error de disco duro lleno</td>
                                        <td><span class="badge bg-success">Hardware</span></td>
                                        <td>204</td>
                                        <td>
                                            <i class="fas fa-star text-warning"></i>
                                            <span class="ms-1">4.7</span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                            <a href="#" class="btn btn-sm btn-outline-success">Editar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Configuración de correo en Outlook</td>
                                        <td><span class="badge bg-purple">Software</span></td>
                                        <td>192</td>
                                        <td>
                                            <i class="fas fa-star text-warning"></i>
                                            <span class="ms-1">4.9</span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                            <a href="#" class="btn btn-sm btn-outline-success">Editar</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <style>
        .bg-purple {
            background-color: #6f42c1 !important;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Página de conocimiento cargada');
        });
    </script>
@endsection

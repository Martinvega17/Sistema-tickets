{{-- resources/views/tickets/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Información del Ticket -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ticket #{{ $ticket->ticket_number }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre completo:</strong> {{ $ticket->user_name }}</p>
                            <p><strong>Cedis Base:</strong> {{ $ticket->cedis_base }}</p>
                            <p><strong>Ubicación:</strong> {{ $ticket->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Área:</strong> {{ $ticket->area }}</p>
                            <p><strong>Dispositivo:</strong> {{ $ticket->device_type }}</p>
                            <p><strong>Estado:</strong> 
                                <span class="badge 
                                    @if($ticket->status == 'abierto') bg-warning
                                    @elseif($ticket->status == 'en_proceso') bg-info
                                    @else bg-success @endif">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <strong>Descripción:</strong>
                        <p class="border p-3 rounded bg-light">{{ $ticket->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Notas del Ticket -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Notas del Ticket</h5>
                </div>
                <div class="card-body">
                    @foreach($ticket->notes as $note)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $note->user->name }}</strong>
                                <small class="text-muted">{{ $note->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-1 mt-2">{{ $note->content }}</p>
                            @if($note->is_internal)
                                <span class="badge bg-dark">Interna</span>
                            @endif
                        </div>
                    @endforeach

                    <!-- Formulario para nueva nota -->
                    <form action="{{ route('tickets.notes.store', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="content" class="form-label">Agregar Nota</label>
                            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_internal" name="is_internal" value="1">
                            <label class="form-check-label" for="is_internal">Nota interna</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Nota</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Panel de Asignación -->
            @if(auth()->user()->role_id == 2) {{-- Solo mesa de control --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Asignar Ticket</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.assign', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Asignar a:</label>
                            <select class="form-select" id="assigned_to" name="assigned_to" required>
                                <option value="">Seleccionar personal de soporte</option>
                                @foreach($soporteUsers as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Asignar Ticket</button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Información de Asignación -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Información de Asignación</h5>
                </div>
                <div class="card-body">
                    <p><strong>Asignado a:</strong> 
                        {{ $ticket->assignedUser ? $ticket->assignedUser->name : 'Sin asignar' }}
                    </p>
                    <p><strong>Fecha creación:</strong> 
                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </p>
                    <p><strong>Última actualización:</strong> 
                        {{ $ticket->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
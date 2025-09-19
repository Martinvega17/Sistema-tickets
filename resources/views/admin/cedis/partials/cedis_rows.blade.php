@foreach ($cedis as $cedi)
    <tr class="hover:bg-gray-50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-semibold text-gray-900">{{ $cedi->nombre }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($cedi->direccion, 40) }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900 bg-blue-50 px-2 py-1 rounded-full inline-block">
                {{ $cedi->region->nombre ?? 'Sin región' }}
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ $cedi->responsable ?: '—' }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ $cedi->telefono ?: '—' }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span
                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
            {{ $cedi->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ ucfirst($cedi->estatus) }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.cedis.edit', $cedi->id) }}"
                    class="text-blue-600 hover:text-blue-900 transition-colors flex items-center" title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Editar</span>
                </a>

                <form action="{{ route('admin.cedis.toggle-status', $cedi->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="estatus"
                        value="{{ $cedi->estatus == 'activo' ? 'inactivo' : 'activo' }}">
                    <button type="submit"
                        class="text-yellow-600 hover:text-yellow-900 transition-colors flex items-center"
                        title="{{ $cedi->estatus == 'activo' ? 'Desactivar' : 'Activar' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            @if ($cedi->estatus == 'activo')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            @endif
                        </svg>
                        <span>{{ $cedi->estatus == 'activo' ? 'Desactivar' : 'Activar' }}</span>
                    </button>
                </form>

                <form action="{{ route('admin.cedis.destroy', $cedi->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors flex items-center"
                        onclick="return confirm('¿Estás seguro de eliminar este CEDIS?')" title="Eliminar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Eliminar</span>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach

@if ($cedis->isEmpty())
    <tr>
        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
            No se encontraron resultados
        </td>
    </tr>
@endif

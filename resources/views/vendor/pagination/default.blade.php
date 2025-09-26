@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination flex justify-between items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true">
                    <span class="px-3 py-1 text-gray-400 cursor-not-allowed">&laquo; Anterior</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-3 py-1 text-blue-600 hover:text-blue-800 transition-colors" rel="prev">&laquo;
                        Anterior</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            <li class="flex space-x-1">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-1 bg-blue-600 text-white rounded">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1 text-blue-600 hover:bg-blue-100 rounded transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-3 py-1 text-blue-600 hover:text-blue-800 transition-colors" rel="next">Siguiente
                        &raquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true">
                    <span class="px-3 py-1 text-gray-400 cursor-not-allowed">Siguiente &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

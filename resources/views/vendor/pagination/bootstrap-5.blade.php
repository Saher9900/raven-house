@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex justify-content-center">
        <ul class="pagination pagination-lg mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link bg-raven-surface text-muted-raven border-0">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link text-gold bg-raven-surface border-0 hover-effect" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link bg-raven-surface text-muted-raven border-0">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item">
                                <span class="page-link bg-gold text-dark border-0 fw-semibold" style="cursor: default;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link text-gold bg-raven-surface border-0 hover-effect" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link text-gold bg-raven-surface border-0 hover-effect" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link bg-raven-surface text-muted-raven border-0">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .hover-effect {
            transition: all 0.3s ease;
        }

        .hover-effect:hover {
            background-color: rgba(212, 175, 55, 0.1) !important;
            text-decoration: none;
        }

        .pagination-lg .page-link {
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }
    </style>
@endif

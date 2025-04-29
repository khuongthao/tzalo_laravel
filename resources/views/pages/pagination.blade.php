@if ($paginator->hasPages())
    <ul class="pagination flex flex-wrap justify-center gap-2 mt-4">
        {{-- Previous Page --}}
        <li class="{{ $paginator->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
            <a href="{{ $paginator->previousPageUrl() ?? '#' }}" class="px-3 py-1 border rounded">‹</a>
        </li>

        {{-- Always show page 1 --}}
        @if ($paginator->currentPage() > 3)
            <li><a href="{{ $paginator->url(1) }}" class="px-3 py-1 border rounded">1</a></li>
            <li class="pointer-events-none px-2">...</li>
        @endif

        {{-- Pages around current --}}
        @for ($i = max(1, $paginator->currentPage() - 2); $i <= min($paginator->lastPage(), $paginator->currentPage() + 2); $i++)
            <li>
                <a href="{{ $paginator->url($i) }}"
                   class="px-3 py-1 border rounded {{ $i == $paginator->currentPage() ? 'bg-gray-800 text-white' : '' }}">
                    {{ $i }}
                </a>
            </li>
        @endfor

        {{-- Always show last page --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="pointer-events-none px-2">...</li>
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}" class="px-3 py-1 border rounded">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page --}}
        <li class="{{ !$paginator->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
            <a href="{{ $paginator->nextPageUrl() ?? '#' }}" class="px-3 py-1 border rounded">›</a>
        </li>
    </ul>
@endif

<style>
    .pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        list-style: none;
        padding: 0;
        margin: 1rem 0;
    }

    .pagination li:hover {
        background-color: #f0f0f0;
    }


</style>

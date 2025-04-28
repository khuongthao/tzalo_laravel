@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page --}}
        <li class="{{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a href="{{ $paginator->previousPageUrl() ?? '#' }}">‹</a>
        </li>

        {{-- Always show 1 --}}
        @if ($paginator->currentPage() > 3)
            <li><a href="{{ $paginator->url(1) }}">1</a></li>
            <li class="disabled">...</li>
        @elseif ($paginator->currentPage() === 3)
            <li><a href="{{ $paginator->url(1) }}">1</a></li>
        @endif

        {{-- Page links --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="{{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
            @endif
        @endforeach

        {{-- Always show last --}}
        @if ($paginator->lastPage() - $paginator->currentPage() > 2)
            <li class="disabled">...</li>
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @elseif ($paginator->lastPage() - $paginator->currentPage() === 2)
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page --}}
        <li class="{{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <a href="{{ $paginator->nextPageUrl() ?? '#' }}">›</a>
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

    .pagination li {
        min-width: 36px;
        text-align: center;
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        color: #2c3e50;
    }

    .pagination li:hover {
        background-color: #f0f0f0;
    }

    .pagination li.active {
        background-color: #2c3e50;
        color: white;
        font-weight: bold;
        border-color: #2c3e50;
    }

    .pagination li.disabled {
        color: #ccc;
        cursor: not-allowed;
        border-color: #eee;
    }

</style>

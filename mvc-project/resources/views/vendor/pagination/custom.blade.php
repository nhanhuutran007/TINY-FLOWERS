@if ($paginator->hasPages())
    <nav class="custom-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-item" rel="prev">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-item disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-item active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-item">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-item" rel="next">&raquo;</a>
        @else
            <span class="page-item disabled">&raquo;</span>
        @endif
    </nav>
@endif

<style>
.custom-pagination {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 40px;
}

.page-item {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: 1px solid #e9ddd2;
    text-decoration: none;
    color: #1e293b;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
}

.page-item:hover:not(.disabled) {
    background: #1e293b;
    color: white;
    border-color: #1e293b;
}

.page-item.active {
    background: #1e293b;
    color: white;
    border-color: #1e293b;
}

.page-item.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    color: #94a3b8;
}
</style>

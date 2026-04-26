@if ($paginator->hasPages())
    <nav class="minimal-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-link disabled"><i class="fas fa-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev"><i class="fas fa-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        <div class="page-numbers">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-link dots">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-link active">{{ sprintf('%02d', $page) }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ sprintf('%02d', $page) }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next"><i class="fas fa-chevron-right"></i></a>
        @else
            <span class="page-link disabled"><i class="fas fa-chevron-right"></i></span>
        @endif
    </nav>
@endif

<style>
.minimal-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    margin-top: 60px;
    padding: 20px 0;
}

.page-numbers {
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    height: 42px;
    padding: 0 10px;
    border-radius: 50%;
    text-decoration: none;
    color: #94a3b8;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: transparent;
    border: 1px solid #f1f5f9;
}

.page-link i {
    font-size: 12px;
}

.page-link:hover:not(.disabled):not(.dots) {
    background: #1e293b;
    color: white;
    border-color: #1e293b;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 41, 59, 0.15);
}

.page-link.active {
    background: #1e293b;
    color: white;
    border-color: #1e293b;
    box-shadow: 0 4px 12px rgba(30, 41, 59, 0.2);
}

.page-link.dots {
    border: none;
    background: transparent;
    cursor: default;
}

.page-link.disabled {
    opacity: 0.3;
    cursor: not-allowed;
    border-color: #f1f5f9;
}

@media (max-width: 640px) {
    .minimal-pagination { gap: 15px; }
    .page-numbers { display: none; } /* Hide numbers on mobile for true minimalism */
}
</style>

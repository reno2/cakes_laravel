@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__li page-item disabled " aria-disabled="true">
                    <span class="page-link pagination__not-active">
                        <svg class="i-svg i-svg__tw">
                            <use xlink:href="/images/icons.svg#icon-arrow_back"></use>
                        </svg>
                    </span>
                </li>
            @else
                <li class="pagination__li page-item">
                    <a class="pagination__active page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <svg class="i-svg i-svg__tw">
                            <use xlink:href="/images/icons.svg#icon-arrow_back"></use>
                        </svg>
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__li page-item">
                    <a class="pagination__active page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <svg class="i-svg i-svg__tw">
                            <use xlink:href="/images/icons.svg#icon-arrow_forward"></use>
                        </svg>
                    </a>
                </li>
            @else
                <li class="pagination__li page-item disabled" aria-disabled="true">
                    <span class="page-link pagination__not-active">
                        <svg class="i-svg i-svg__tw">
                            <use xlink:href="/images/icons.svg#icon-arrow_forward"></use>
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

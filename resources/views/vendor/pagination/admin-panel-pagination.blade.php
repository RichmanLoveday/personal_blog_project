@if ($paginator->hasPages())
    <div class="w-100 d-flex justify-content-center">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0);" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $start = max(1, $currentPage - 1);
                $end = min($lastPage, $currentPage + 1);
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">{{ $page }}</a>
                    </li>
                @else
                    <li class="page-item"><a class="page-link"
                            href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0);" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif

@if($paginator->hasPages())
    <ul class="pagination">
        @if (!$paginator->onFirstPage())
            <li>
                <a href="{{ $paginator->url(1) }}">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
        @endif
        @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $i => $url)
            <li class="{{ $i === $paginator->currentPage() ? "active" : "" }}">
                <a href="{{ $url }}">{{ $i }}</a>
            </li>
        @endforeach
        @if($paginator->currentPage() !== $paginator->lastPage())
            <li>
                <a href="{{ $paginator->url($paginator->lastPage()) }}">
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
        @endif
    </ul>
@endif



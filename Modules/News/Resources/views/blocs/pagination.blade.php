{{--@if ($paginator->hasPages())
    <div class="pagination">
        <div class="pagination__inner">
            @if ($paginator->onFirstPage())
                <a class="_item arrow arrow-left" disabled=""><i></i></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="_item arrow arrow-left"><i></i></a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="_item dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="_item current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="_item">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="_item arrow arrow-right"><i></i></a>
            @else
                <a class="_item arrow arrow-right" disabled=""><i></i></a>
            @endif
        </div>
    </div>
@endif--}}
@if ($paginator->hasPages())
    <div class="content-news-archive__pagination"><span>Номер страницы</span>
        <div class="form-container">
            <div class="form-group">
                <div class="input-wrap">
                    <input type="number" value="9" required="required" class="form-control my-form-custom"/>
                </div>
            </div>
        </div>
        <div class="content-news-archive__pagination-go">
            <button type="button">Перейти</button>
        </div>
        <div class="content-news-archive__pagination-pages-wrap">
            @if ($paginator->onFirstPage())
                    <a disabled="">Пред.</a>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}">Пред.</a>
            @endif

            <div class="content-news-archive__pagination-pages">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span>{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <a class="active">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}">След.</a>
            @else
                <a disabled="">След.</a>
            @endif
        </div>
    </div>
@endif
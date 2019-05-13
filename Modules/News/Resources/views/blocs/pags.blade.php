@if ($paginator->hasPages())
    <div class="content-news-archive__pagination"><span>{{trans('main.nomer_stranitsy')}}</span>
        <form style="margin: 0; padding: 0; display: contents;">
            @foreach(request()->all() as $key => $val)
                @if($key!=='page') <input type="hidden" name="{{ $key }}" value="{{ $val }}" /> @endif
            @endforeach
            <div class="form-container">
                <div class="form-group">
                    <div class="input-wrap">
                        <input type="number" name="page" value="{{$paginator->currentPage()}}" required="required" class="form-control my-form-custom"/>
                    </div>
                </div>
            </div>
            <div class="content-news-archive__pagination-go">
                <button type="submit">{{trans('main.pereyti')}}</button>
            </div>
        </form>
        <div class="content-news-archive__pagination-pages-wrap">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a disabled="">{!! trans('pagination.previous_my') !!}</a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}">{!! trans('pagination.previous_my') !!}</a>
            @endif
            <div class="content-news-archive__pagination-pages">
                @if($paginator->currentPage() > 3)
                    <a href="{{ $paginator->url(1) }}">1</a>
                @endif
                @if($paginator->currentPage() > 4)
                    <span>...</span>
                @endif
                @foreach(range(1, $paginator->lastPage()) as $i)
                    @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                        @if ($i == $paginator->currentPage())
                            <a class="active">{{ $i }}</a>
                        @else
                            <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        @endif
                    @endif
                @endforeach
                @if($paginator->currentPage() < $paginator->lastPage() - 3)
                    <span>...</span>
                @endif
                @if($paginator->currentPage() < $paginator->lastPage() - 2)
                    <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                @endif
            </div>
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}">{!! trans('pagination.next_my') !!}</a>
            @else
                <a disabled="">{!! trans('pagination.next_my') !!}</a>
            @endif
        </div>
    </div>
@endif
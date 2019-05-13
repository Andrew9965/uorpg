@php
    $datas = collect($page->collapse);
    if(isset($folder) && $folder) $datas = $datas->where('folder', $folder)->all();
@endphp
<div class="content-classes">
    <div class="jeneral_wrapper">
        @foreach($datas as $data)
        <div class="content-classes__item js-collapse">
            <div class="content-classes__item-ttl clickToOpen" @if($data->color) style="background-color: rgba({{implode(', ', \App\Libs\DateFormat::hexToRgb($data->color))}}, 0.5);" @endif>
                <div class="content-classes__switch">
                    <div class="arrows">
                        <button type="button" class="arrow-up"><i class="ico ico-up-news-watch"></i></button>
                        <button type="button" class="arrow-down"><i class="ico ico-down-news-watch"></i></button>
                    </div>
                </div>
                @if(!empty(strip_tags($data->title)))
                <h2>{{$data->title}}</h2>
                @endif
            </div>
            <article>
                @if($data->img) <div><img src="{{$data->img}}" alt="icon"/></div> @endif
                <div>{!! $data->description !!}</div>
            </article>
            <div class="js-collapse-content">
                <section>
                    {!! $data->content !!}
                </section>
            </div>
        </div>
        @endforeach
    </div>
</div>
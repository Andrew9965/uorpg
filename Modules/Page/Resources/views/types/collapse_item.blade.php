@php
    $datas = collect($page->collapse_item);
    if(isset($folder) && $folder) $datas = $datas->where('folder', $folder)->all();
@endphp
<style>
    .content-resources__item-inner img {
        max-width: none;
    }
</style>
<div class="content-resources">
    <div class="jeneral_wrapper">
        @foreach($datas as $data)
        <div class="content-resources__item js-collapse">
            <div class="content-resources__item-ttl clickToOpen" @if($data->color) style="background-color: {{$data->color}};" @endif>
                <div class="content-resources__switch">
                    <div class="arrows">
                        <button type="button" class="arrow-up"><i class="ico ico-up-news-watch"></i></button>
                        <button type="button" class="arrow-down"><i class="ico ico-down-news-watch"></i></button>
                    </div>
                </div>
                @if(!empty(strip_tags($data->title)))
                    <h2>{{$data->title}}</h2>
                @endif
            </div>
            <div class="js-collapse-content">
                <div class="content-resources__item-inner">
                    {!! $data->content !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
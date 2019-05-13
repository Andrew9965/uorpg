@php
    $datas = collect($page->header_table);
    if(isset($folder) && $folder) $datas = $datas->where('folder', $folder)->all();
@endphp
<div class="content-fractions">
    <div class="jeneral_wrapper">
        @foreach($datas as $data)
        <article>
            <h2 @if($data->color) style="background-color: rgba({{implode(', ', \App\Libs\DateFormat::hexToRgb($data->color))}}, 0.5);" @endif>{{$data->title}}</h2>
            {!! $data->content !!}
        </article>
        @endforeach
    </div>
</div>
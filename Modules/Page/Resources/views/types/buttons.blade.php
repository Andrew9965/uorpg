@php
    $datas = collect($page->buttons);
    if(isset($folder) && $folder) $datas = $datas->where('folder', $folder)->all();
@endphp
<div class="content-information">
    <div class="content-information__wrap">
    @foreach($datas as $data)
        <a href="{{$data->url}}" target="{{$data->target}}" class="content-information__item">
            <div class="content-information__item-img">
                <img src="{{asset($data->img)}}" alt="icon"/>
            </div>
            <span>{{$data->title}}</span>
        </a>
    @endforeach
    </div>
</div>
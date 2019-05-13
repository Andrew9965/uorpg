@php
    $title = 'Main';
    $keywords = '';
    $description = '';
    if(isset($page)){
        $title = empty($page->meta_title) ? $page->title : $page->meta_title;
        $keywords = $page->meta_keywords;
        $description = $page->meta_description;
    }
@endphp
<title>{{config('common.title.'.App::getLocale())}} {{$title}}</title>
<meta name="keywords" content="{{$keywords}}">
<meta name="description" content="{{$description}}">
<link rel="shortcut icon" href="{{config('favicon.link')}}" type="image/png">

<meta charset="utf-8"/>
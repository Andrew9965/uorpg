<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <style> a { color: white; } </style>
    @include('sections.meta')
    @include('sections.styles')
    @stack('styles')
</head>
<body>
<div class="l-wrapper">
    @include('sections.header')
    <main>
        @include('sections.menu')
        <div class="c-basic">
            @include('sections.left_sidebar')

                @yield('content')

            @include('sections.right_sidebar')
        </div>
    </main>
    @include('sections.footer')
</div>
@include('sections.modal')
@stack('modal')
@include('sections.scripts')
@stack('scripts')
</body>
</html>
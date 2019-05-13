<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin._partials._head')
</head>
<body>
<div id="app"></div>
    <div class="container-fluid font-admin">

        <header class="row">
            @include('admin._partials._header')
        </header>

        <div id="main" class="row">

            @yield('content')

        </div>

        <footer class="row">
            @include('admin._partials._footer')
            @yield('script')

        </footer>

    </div>
</body>
</html>

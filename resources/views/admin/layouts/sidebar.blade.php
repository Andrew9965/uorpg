<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin._partials._head')
</head>
<body>
<div id="app"></div>
    <div class="container-fluid">
        <header class="row">
            @include('admin._partials._header')
        </header>

        <div id="main" class="row">

            <!-- sidebar content -->
            <div id="sidebar" class="col-md-3 col-sm-4">
                @include('admin._partials._sidebar')
            </div>

            <!-- main content -->
            <div id="content" class="col-md-9 col-sm-8 col-xs-12">
                @yield('content')
            </div>

        </div>

        <footer class="row">
            @include('admin._partials._footer')
            @yield('script')
        </footer>

    </div>
</body  >
</html>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @hasSection('title')
        <title>@yield('title')</title>
    @else
        <title>Empty title</title>
    @endif

    @section('styles')
        @vite([
            'resources/assets/css/icons/font/bootstrap-icons.scss',
            'resources/assets/css/app.css',
            'resources/assets/css/styles.scss'
        ])
    @show
</head>
<body>

<div class="wrapper d-flex flex-column">
    <header class="header">
        @section('header')
        @show
    </header>

    <main class="main flex-fill my-5">
        @section('content')

        @show
    </main>

    <footer class="footer">
        @section('footer')
        @show
    </footer>
</div>

@section('scripts')
    @vite(['resources/assets/js/app.js', 'resources/assets/js/main.ts'])
@show
</body>
</html>


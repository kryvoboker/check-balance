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
        @vite(['resources/assets/css/app.css', 'resources/assets/css/styles.scss'])
    @show
</head>
<body>

<div class="wrapper d-flex flex-column">
    @section('header')
        <header class="header">
            <div class="container">

            </div>
        </header>
    @show

    <main class="main flex-fill my-5">
        <div class="container">
            @section('content')

            @show
        </div>
    </main>

    @section('footer')
        <footer class="footer">
            <div class="container">

            </div>
        </footer>
    @show
</div>

@section('scripts')
    @vite(['resources/assets/css/app.css', 'resources/assets/js/main.ts'])
@show
</body>
</html>


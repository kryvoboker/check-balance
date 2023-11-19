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
            <div class="container">
                <nav class="navbar bg-body-tertiary justify-content-end">
                    <div class="main-actions">
                        @if(isset($current_route_name) and $current_route_name == 'costs.index')
                            <a class="btn btn-outline-success create-cost" href="{{ route('costs.create') }}">
                                <i class="bi bi-plus-circle-fill"></i>

                                {{ __('cost/main.create_cost') }}
                            </a>

                            <button class="btn btn-outline-danger delete-cost" type="button">
                                <i class="bi bi-trash"></i>

                                {{ __('cost/main.delete_cost') }}
                            </button>
                        @endif

                        @isset($cost_id)
                            <a href="{{ route('costs.edit', ['cost' => $cost_id]) }}" class="btn btn-outline-info">
                                <i class="bi bi-pencil-fill"></i>
                                <span>{{ __('cost/show.text_edit_cost') }}</span>
                            </a>
                        @endisset

                        <a href="{{ route('logout') }}" class="btn btn-outline-danger">
                            {{ __('common/header.text_logout') }}
                        </a>
                    </div>
                </nav>
            </div>
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


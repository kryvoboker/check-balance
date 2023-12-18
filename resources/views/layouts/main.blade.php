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
                        @endif

                        @if(isset($cost_id) and isset($current_route_name))
                            @if($current_route_name != 'costs.index')
                                    <a href="{{ route('costs.index') }}" class="btn btn-outline-success">
                                        <i class="bi bi-house-door"></i>
                                        <span>{{ __('common/header.text_go_to_home') }}</span>
                                    </a>
                            @endif

                            @if($current_route_name == 'costs.edit')
                                <a href="{{ route('costs.show', ['cost' => $cost_id]) }}" class="btn btn-outline-warning">
                                    <i class="bi bi-arrow-return-left"></i>
                                    <span>
                                        {{ __('common/header.text_back') }}
                                    </span>
                                </a>
                            @endif

                            @if($current_route_name == 'costs.show')
                                <a href="{{ route('costs.edit', ['cost' => $cost_id]) }}" class="btn btn-outline-info">
                                    <i class="bi bi-pencil-fill"></i>
                                    <span>{{ __('cost/show.text_edit_cost') }}</span>
                                </a>
                            @elseif($current_route_name == 'costs.edit')
                                <button class="btn btn-outline-info" type="submit" form="edit-cost-form">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>{{ __('cost/edit.text_edit_update') }}</span>
                                </button>
                            @endif

                            @if($current_route_name == 'costs.show' or $current_route_name == 'costs.edit')
                                <button class="btn btn-outline-danger delete-cost-btn" type="submit"
                                        form="delete-cost-form">
                                    <i class="bi bi-trash"></i>

                                    {{ __('cost/main.delete_cost') }}
                                </button>
                            @endif
                        @endif

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

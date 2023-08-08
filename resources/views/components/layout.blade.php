<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Job Board</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="layout-body">
        
    <nav class="mb-2 flex items-center justify-between text-xs font-medium">
        <ul class="flex space-x-2">
            
            <li>
                <a href="{{ route('auth.setlang','en') }}" @class(['text-blue-400' => session('locale')==='en'])>
                    English
                </a>
            </li>
            <li><a href="{{ route('auth.setlang','zh_TW') }}" @class(['text-blue-400' => (is_null(session('locale')) || (session('locale') === 'zh_TW') )])>繁體中文</a></li>
        </ul>
    </nav>
    <nav class="nav_box">
        <ul class="flex space-x-2">
            <li>
                <a href="{{ route('jobs.index') }}">{{ __('Home') }}</a>
            </li>
        </ul>
        <ul class="flex items-center space-x-2">
            @auth
                <li>{{ auth()->user()->name ?? __('Anynomus') }}</li>
                <li class="flex">
                    <a href="{{ route('my-job-applications.index') }}" class="link">{{ __('Applications') }}</a>
                </li>
                <li class="flex">
                    <a href="{{ route('my-jobs.index') }}" class="link">{{ __('My Jobs') }}</a>
                </li>
                <li>
                    <form action="{{ route('auth.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button>{{ __('Logout') }}</x-button>
                    </form>
                </li>
            @else
                <li >
                    <a href="{{ route('auth.create') }}">{{ __('Sign in') }}</a>
                </li>
            @endauth
        </ul>
    </nav>

    @if ( session('success') )
        <div role="alert" class="success_msg">
            <p class="font-bold">{{ __('Success') }}!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if ( session('error') )
        <div role="alert" class="error_msg">
            <p class="font-bold">{{ __('Error') }}!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{ $slot }}
    </body>
</html>

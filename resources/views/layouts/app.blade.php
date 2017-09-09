<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <script>
        window.App = {!! 
           json_encode([
             'signedIn' => Auth::check(),
             'user' => Auth::user()
            ])
         !!}
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Forum') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            padding-bottom: 100%:
        }

        .level {
            display: flex;
            align-items: center;
        }

        .flex {
            flex: 1;
        }

        .delete {
            background: rgba(255, 0, 0, 0.5);
            color: white;
            font-style: italic;
        }

        .delete:hover {
            background: red;
            color: white;
        }

        .mr-1 {
            margin-right: 1em;
        }

        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body>
<div id="app">
    @include('nav')
    @yield('content')


    <flash message="{{ session('flash') }}"></flash>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

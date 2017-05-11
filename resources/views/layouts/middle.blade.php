<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <style>
        body {
            padding: 40px 0px 40px 0px;

        }

    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = {
            "csrfToken": document.getElementById('csrf_token').attributes['content'].value,
        }

    </script>
</head>
<body>
<div id="app">

    <div class="container">

        @yield('container')

    </div> <!-- /container -->


</div>

<!-- Scripts -->
<script src="/js/app.js"></script>
</body>
</html>

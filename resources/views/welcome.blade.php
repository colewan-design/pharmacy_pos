<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>POS</title>
        <link rel="stylesheet" href="/css/app.css">

        <script>
        
            (function () {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
        </script>

    </head>
    <body class="hold-transition sidebar-mini">
        <div id="app">
        @if(Auth::check())
            <mainapp :user="{{Auth::user()}}" :permission="{{Auth::user()->role->permission}}"></mainapp>
        @else
            <mainapp :user="false"></mainapp>
        @endif
        </div>
    </body>
    <script src="/js/app.js"></script>
</html>

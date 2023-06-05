<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>POS</title>
        <link rel="stylesheet" href="/css/app.css">

    </head>
    <body>
        <div id="print_kitchen">
            <print_kitchen></print_kitchen>
        </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
</html>

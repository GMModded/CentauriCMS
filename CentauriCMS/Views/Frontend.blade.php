<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Centauri CMS » {{ $page->title }}</title>
    </head>

    <body>
        <h1>Header</h1>

        <hr>

        {!! $content !!}

        <hr>
        
        <h1>Footer</h1>
    </body>
</html>

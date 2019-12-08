<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Centauri CMS | {{ $page->title }}</title>
    </head>

    <body>
        <h1>Section Header</h1>

        <hr>
        <h1>Section Content</h1>
        {!! $content !!}
        <hr>
        
        <h1>Section Footer</h1>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Centauri CMS » {{ $page->title }}</title>

        <link rel="stylesheet" href="{{ asset('public/frontend/css/centauri.min.css') }}">
    </head>

    <body>
        <section id="header" style="position:absolute;z-index:1;">
            <div class="container-fluid" style="position:fixed;top:0;left:0;width:100%;padding:2rem;border-bottom:1px solid #fff;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1>
                                <font color="#ffffff">
                                    Header
                                </font>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="content">
            {!! $content !!}
        </section>

        <section id="footer">
            <div class="container-fluid" style="background:black;padding:2rem;">
                <div class="row">
                    <div class="col-12">
                        <h1>
                            <font color="#ffffff">
                                Footer
                            </font>
                        </h1>
                    </div>
                </div>
            </div>
        </section>

        <script src="{{ asset('public/frontend/js/centauri.min.js') }}" async></script>
    </body>
</html>

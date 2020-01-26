<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Centauri CMS » {{ $page->title }}</title>
    </head>

    <body>
        <section id="header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header-view p-2" style="background:black;padding:2rem;">
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
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-view p-2" style="background:black;padding:2rem;">
                            <h1>
                                <font color="#ffffff">
                                    Footer
                                </font>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>

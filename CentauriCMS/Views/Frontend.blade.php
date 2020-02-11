<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Centauri CMS » {{ $page->title }}</title>

        <link rel="stylesheet" href="{{ asset('public/frontend/css/centauri.min.css') }}">

        <link rel="stylesheet" href="/packages/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/packages/slick/slick-theme.css">
        <link rel="stylesheet" href="/packages/slick/slick.css">

        <script src="/packages/jquery/jquery.min.js"></script>
        <script src="/packages/slick/slick.min.js" async></script>
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

        <script async>
            $.ContentElement = (ceName) => {
                return $("[data-contentelement='" + ceName + "']");
            };

            $.ContentElement("slider").slick({
                dots: true,
                infinite: false,
                speed: 750,
                autoplay: true,
                autoplaySpeed: 4000,

                prevArrow: "<button class='slick-prev slick-arrow' aria-label='Previous' type='button'><svg xmlns='http://www.w3.org/2000/svg' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='chevron-left' class='svg-inline--fa fa-chevron-left fa-w-10' role='img' viewBox='0 0 320 512'><path fill='currentColor' d='M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z' /></svg></button>",
                nextArrow: "<button class='slick-next slick-arrow' aria-label='Next' type='button'><svg xmlns='http://www.w3.org/2000/svg' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='chevron-right' class='svg-inline--fa fa-chevron-right fa-w-10' role='img' viewBox='0 0 320 512'><path fill='currentColor' d='M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z'/></svg></button>"
            });
        </script>
    </body>
</html>

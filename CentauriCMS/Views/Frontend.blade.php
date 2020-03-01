<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        {!! $additionalHeadTagContent !!}
        <title>Centauri CMS » {{ $page->title }}</title>
        <link rel="stylesheet" href="{{ asset('public/frontend/css/centauri.min.css') }}" media="print" onload="this.media='all'">
    </head>

    <body>
        <style>
            @media (max-width: 767px) {
                #header {
                    position: unset !important;
                }

                #content .item .text-view h4 {
                    font-size: 30px;
                    white-space: nowrap;
                }

                .button-view {
                    white-space: nowrap;
                }
            }
        </style>

        <script async>window.onload=()=>{document.querySelectorAll("[data-contentelement]")[0].style.maxHeight="550px";};</script>

        <section id="header" style="position:absolute;z-index:1;">
            <div class="container-fluid" style="position:fixed;top:0;left:0;width:100%;padding:2rem;border-bottom:1px solid #fff;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-8">
                                    <h1>
                                        <a href="/" style="border: 1px solid white;" class="px-2 pb-2">
                                            <font color="#ffffff">
                                                Logo
                                            </font>
                                        </a>
                                    </h1>
                                </div>

                                <div class="col">
                                    <ul class="list-unstyled d-flex align-items-center h-100">
                                        @foreach(BuildBladeHelper::treeByPid(1) as $page)
                                            <li class="px-2">
                                                <a href="{{ BuildBladeHelper::linkByUid($page->uid) }}" style="font-size: 20px; color: #fff;">
                                                    {{ $page->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
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

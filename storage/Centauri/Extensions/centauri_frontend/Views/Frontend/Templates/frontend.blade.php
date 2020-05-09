@php
    $title = $page->pageTitlePrefix ? $page->pageTitlePrefix . $page->title : $page->title;
@endphp

@if(empty($postParams))
    <!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
        <head>
            {!! $additionalHeadTagContent !!}
            <title>{{ $title }}</title>
            <link rel="stylesheet" href="{{ asset('public/frontend/css/centauri.min.css') }}" media="print" onload="this.media='all'">
        </head>

        <body>
            <section id="header" style="position:absolute;z-index:1;">
                <div class="container-fluid" style="position:fixed;top:0;left:0;width:100%;padding:2rem;border-bottom:1px solid #fff;">
                    <div class="progress md-progress inactive" style="position: absolute;bottom: -20px;width: 100%;left: 0;height:4px;background:gold;">
                        <div class="indeterminate" style="background:white;"></div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-8">
                                        <a href="/" class="anim-underline" style="color: #fff;font-size: 24px;letter-spacing: -1px;font-weight: bold;">
                                            CentauriCMS
                                        </a>
                                    </div>

                                    <div class="col">
                                        <ul class="list-unstyled d-flex align-items-center h-100">
                                            @foreach(BuildBladeHelper::treeByPid(1, $page->uid) as $page)
                                                <li class="px-2">
                                                    <a class="nav-item anim-underline" href="{{ BuildBladeHelper::linkByUid($page->uid) }}" style="font-size: 20px; color: #fff;{{ $page->current ? ' text-decoration: underline;' : '' }}">
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
@else
    {!! $content !!}

    {{-- {{ dd(get_defined_vars()["__data"]) }} --}}

    <script>
        var __dynPageData = {
            additionalHeadTagContent: {!! json_encode($additionalHeadTagContent) !!},
            title: "{!! $title !!}",
            lid: {!! $page->lid !!}
        };
    </script>
@endif

@php
    $title = $page->pageTitlePrefix ? $page->pageTitlePrefix . $page->title : $page->title;
    $origPage = $page;
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
            <section id="header" style="position:absolute;z-index:10;">
                <div class="container-fluid" style="position:fixed;top:0;left:0;width:100%;padding:2rem;background: linear-gradient(180deg, #303a4f, #2a3345);">
                    <div class="progress md-progress inactive" style="position: absolute;bottom: -20px;width: 100%;left: 0;height:4px;background:gold;">
                        <div class="indeterminate" style="background:white;"></div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-8 align-items-center d-flex">
                                        <a href="/" class="anim-underline" style="color: #fff;font-size: 28px;letter-spacing: -1px;font-weight: bold;">
                                            CentauriCMS
                                        </a>
                                    </div>

                                    <div class="col">
                                        <ul class="list-unstyled d-flex align-items-center h-100">
                                            @foreach(BuildBladeHelper::treeByPid(1, $page->uid) as $page)
                                                @if($page->page_type == "page" && $page->storage_id == null)
                                                    <li class="px-2">
                                                        <a class="nav-item anim-underline{{ $page->current ? ' active' : '' }}" href="{{ BuildBladeHelper::linkByUid($page->uid) }}" style="font-size: 20px; color: #fff;">
                                                            {{ $page->title }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            <li class="ml-3 py-2 px-3 btn btn-info">
                                                <a class="nav-item" href="#plans" style="font-size: 20px; color: #fff; text-transform: capitalize; text-decoration: none;">
                                                    Plans
                                                </a>
                                            </li>
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
                <div class="container-fluid" style="background:linear-gradient(180deg, #303a4f, #2a3345);padding:2rem;">
                    <div class="row">
                        <div class="col-12">
                            <div class="container">
                                <ul class="list-unstyled mb-0 d-flex align-items-center justify-content-center h-100">
                                    @foreach(BuildBladeHelper::treeByStorageId(3, $origPage) as $page)
                                        <li class="px-2">
                                            <a class="nav-item anim-underline{{ $page->current ? ' active' : '' }}" href="{{ BuildBladeHelper::linkByUid($page->uid) }}" style="font-size: 20px; color: #fff;">
                                                {{ $page->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <p style="text-align: center;font-size: 20px;color: white;" class="mt-3 mb-0">
                                    This site was built using CentauriCMS.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script src="{{ asset('public/frontend/js/centauri.min.js') }}" async defer></script>
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

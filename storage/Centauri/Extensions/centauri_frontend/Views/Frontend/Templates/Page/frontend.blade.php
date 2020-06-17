@php
    $title = $page->pageTitlePrefix ? $page->pageTitlePrefix . $page->title : $page->title;
    $origPage = $page;

    $time = time();
    $startId = $origPage->getDomain()->rootpageuid;
@endphp

@if(empty($postParams))
    <!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
        <head>
            {!! $additionalHeadTagContent !!}
            <title>{{ $title }}</title>
            <link rel="stylesheet" href="{{ asset('public/frontend/css/centauri.min.css') }}">
        </head>

        <body data-version="{{ $time }}">
            <section id="header">
                <div class="container-fluid sticked">
                    <div class="progress md-progress inactive">
                        <div class="indeterminate" style="background:white;"></div>
                    </div>

                    <div class="container h-100">
                        <div class="row h-100">
                            <div class="col-12">
                                <div class="row h-100 wrappers">
                                    <div class="col-2 logo align-items-center d-flex h-100">
                                        <a href="/" class="anim-underline" style="color: #fff;font-size: 28px;letter-spacing: -1px;font-weight: bold;">
                                            CentauriCMS
                                        </a>
                                    </div>

                                    <div class="col desktop d-xl-flex d-none" style="justify-content: flex-end;">
                                        <ul class="list-unstyled d-flex align-items-center h-100">
                                            @foreach(Centauri\CMS\BladeHelper\BuildBladeHelper::treeByPid($startId, $origPage->uid, $origPage->lid) as $page)
                                                @if($page->page_type == "page" && $page->storage_id == null)
                                                    <li class="px-2">
                                                        <a 
                                                            class="nav-item anim-underline{{ $page->current ? ' active' : '' }}"
                                                            href="{{ Centauri\CMS\BladeHelper\BuildBladeHelper::linkByUid($page->uid) }}"
                                                            data-uid="{{ $page->uid }}"
                                                        >
                                                            {{ $page->title }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            <a 
                                                href="{!!
                                                    \Centauri\CMS\BladeHelper\URIBladeHelper::linkAction(
                                                        "\Centauri\Extension\Frontend\Controller\FrontendController",
                                                        "login"
                                                    )
                                                !!}"
                                                style="font-size: 16px; text-transform: capitalize; border-radius: 0;"
                                                class="nav-item btn btn-info px-3 py-2 waves-effect waves-light"
                                            >
                                                Login
                                            </a>
                                        </ul>
                                    </div>

                                    <div class="col mobile d-block d-xl-none">
                                        <div id="hamburger">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="content">
                @if($origPage->cached_content)
                    {!! $origPage->cached_content !!}
                @else
                    {!! $content !!}
                @endif
            </section>

            <section id="footer">
                <div class="container-fluid" style="background:linear-gradient(180deg, #303a4f, #2a3345);padding:2rem;">
                    <div class="row">
                        <div class="col-12">
                            <div class="container">
                                <ul class="list-unstyled mb-0 d-flex align-items-center justify-content-center">
                                    @foreach(Centauri\CMS\BladeHelper\BuildBladeHelper::treeByStorageId(3, $origPage) as $page)
                                        <li class="px-2">
                                            <a class="nav-item anim-underline{{ $page->current ? ' active' : '' }}" href="{{ Centauri\CMS\BladeHelper\BuildBladeHelper::linkByUid($page->uid) }}" style="font-size: 20px; color: #fff;">
                                                {{ $page->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <p style="text-align: center;font-size: 20px;color: white;" class="mt-3 m-0">
                                    <small>
                                        This site was built using CentauriCMS. - Version: 3.5.8
                                    </small>
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
    @if($origPage->cached_content)
        {!! $origPage->cached_content !!}
    @else
        {!! $content !!}
    @endif

    <script>
        var __dynPageData = {
            additionalHeadTagContent: {!! json_encode($additionalHeadTagContent) !!},
            title: "{!! $title !!}",
            lid: {!! $origPage->lid !!},
            uid: {!! $origPage->uid !!}
        };
    </script>
@endif

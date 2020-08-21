@php
    $title = $page->pageTitlePrefix ? $page->pageTitlePrefix . $page->title : $page->title;
    $origPage = $page;

    $time = time();

    $domain = $origPage->getDomain();

    if(!is_null($domain)) {
        $startId = $origPage->getDomain()->rootpageuid;
    } else {
        $startId = 0;
        dd("HH PRANK YA BRO", $origPage, $domain);
    }
@endphp

@if(empty($postParams))
    <!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
        <head>
            {!! $additionalHeadTagContent !!}
            <title>{{ $title }}</title>
        </head>

        <body data-version="{{ $time }}">
            <section id="header">
                <div class="container-fluid sticked">
                    <div class="progress md-progress inactive">
                        <div class="indeterminate" style="background:white;"></div>
                    </div>

                    <div class="nav-wrapper justify-content-space-between h-100-childs flex-centration-childs flex-ai-center-childs px-3">
                        <div>
                            <a href="/" class="anim-underline" style="color: #fff;font-size: 28px;font-weight: bold;color: #ff699b;font-family: fatfrank;">
                                CentauriCMS
                            </a>
                        </div>

                        <ul class="list-unstyled w-100 justify-content-center">
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
                        </ul>

                        <div>
                            <a 
                                href="{!!
                                    \Centauri\CMS\BladeHelper\URIBladeHelper::linkAction(
                                        "\Centauri\Extension\Frontend\Controller\FrontendController",
                                        "login"
                                    )
                                !!}"
                                style="font-size: 16px; text-transform: capitalize; border-radius: 0;"
                                class="nav-item btn btn-hotpink px-3 py-2 waves-effect waves-light"
                            >
                                Login
                            </a>
                        </div>

                        <div class="col mobile d-block d-xl-none p-xl-0">
                            <div id="hamburger">
                                <span></span>
                                <span></span>
                                <span></span>
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

                                <p class="mt-3 m-0" style="text-align: center;font-size: 20px;color: white;">
                                    <small>
                                        This site was built using CentauriCMS.<br>
                                        Version: {{ Centauri\CMS\Centauri::getVersion() }}
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {!! $additionalBodyTagContent !!}
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

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="robots" content="noindex,nofollow">
        <title>Centauri CMS > Page not found!</title>
        <link rel="stylesheet" href="{{ asset('public/frontend/css/centauri.min.css') }}" media="print" onload="this.media='all'">
    </head>

    <body>
        <section id="header" style="position:absolute;z-index:1;">
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
                                        @foreach(BuildBladeHelper::treeByPid(1, null) as $page)
                                            @if($page->page_type != "storage")
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
            <h6>
                Sorry, but the page you were looking for could not been found!<br/>
                Maybe you can try finding what you were looking for by our search:
            </h6>

            <hr>

            <form action="fsdf">
                <input type="text" placeholder="Search...">
            </form>
        </section>

        <section id="footer">
            <div class="container-fluid" style="background:linear-gradient(180deg, #303a4f, #2a3345);padding:2rem;">
                <div class="row">
                    <div class="col-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center">
                                    @foreach(BuildBladeHelper::treeByPid(3, null) as $page)
                                        @if($page->page_type != "storage")
                                            <li class="px-2">
                                                <a class="nav-item anim-underline{{ $page->current ? ' active' : '' }}" href="{{ BuildBladeHelper::linkByUid($page->uid) }}" style="font-size: 20px; color: #fff;">
                                                    {{ $page->title }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="{{ asset('public/frontend/js/centauri.min.js') }}" async defer></script>
    </body>
</html>
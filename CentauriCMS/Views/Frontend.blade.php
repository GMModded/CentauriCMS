<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        {!! $additionalHeadTagContent !!}
        <title>{{ $page->pageTitlePrefix ? $page->pageTitlePrefix . $page->title : $page->title }}</title>
    </head>

    <body>
        <section id="header">
            <ul class="list-unstyled d-flex align-items-center h-100">
                @foreach(\Centauri\CMS\BladeHelper\BuildBladeHelper::treeByPid(1, 1, 1) as $page)
                    @if($page->page_type != "storage")
                        <li class="px-2">
                            <a href="{{ \Centauri\CMS\BladeHelper\BuildBladeHelper::linkByUid($page->uid) }}" style="font-size: 20px; color: #000;">
                                {{ $page->title }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>

        <section id="content">
            {!! $content !!}
        </section>
    </body>
</html>

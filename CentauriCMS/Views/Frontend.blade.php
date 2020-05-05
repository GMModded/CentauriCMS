<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        {!! $additionalHeadTagContent !!}
        <title>{{ $page->pageTitlePrefix ? $page->pageTitlePrefix . $page->title : $page->title }}</title>
    </head>

    <body>
        <section id="header">
            <ul class="list-unstyled d-flex align-items-center h-100">
                @foreach(BuildBladeHelper::treeByPid(1) as $page)
                    <li class="px-2">
                        <a href="{{ BuildBladeHelper::linkByUid($page->uid) }}" style="font-size: 20px; color: #000;">
                            {{ $page->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>

        <section id="content">
            {!! $content !!}
        </section>

        <section id="footer"></section>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>CentauriCMS » {{ isset($title) ? $title : "" }}</title>
        <link rel="stylesheet" href="{{ \Centauri\CMS\Helper\GulpRevHelper::include(
            \Centauri\CMS\Utility\PathUtility::getAbsURL("public/backend"),
            "css",
            "centauri.min.css"
        ) }}">
    </head>

    <body>
        <div id="app">
            @if($data["dashboard"])
                <section id="dashboard">
                    <div class="hamburger d-block d-lg-none waves-effect waves-light">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>

                    <div class="logo-view">
                        <h4 class="text-center">
                            <span>
                                Centauri CMS
                            </span>

                            <i class="fas fa-rocket"></i>

                            <br>

                            <small>
                                v{{ Centauri\CMS\Centauri::getVersion() }}

                                <small>
                                    <i>
                                        {{ Centauri\CMS\Centauri::getState() }}
                                    </i>
                                </small>
                            </small>
                        </h4>
                    </div>

                    <div id="modules" class="mt-5">
                        @foreach($data["modules"] as $moduleid => $module)
                            @if(isset($module["modules"]))
                                <div class="my-4">
                                    <span class="group">
                                        {{ $module["label"] }}
                                    </span>

                                    @foreach($module["modules"] as $groupedModuleid => $groupedModule)
                                        <div 
                                            class="module waves-effect waves-light{{ isset($data['moduleid']) ? ($data['moduleid'] == $groupedModuleid ? ' active' : '') : '' }}"
                                            data-module-id="{{ $groupedModuleid }}"
                                        >
                                            <div class="icon-view">
                                                @if($groupedModuleid == "notifications")
                                                    <span>
                                                        {{ $groupedModule["data"] }}
                                                    </span>
                                                @endif

                                                {!! $groupedModule["icon"] !!}
                                            </div>

                                            <div class="text-view">
                                                {!! $groupedModule["title"] !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div 
                                    class="module waves-effect waves-light{{ isset($data['moduleid']) ? ($data['moduleid'] == $moduleid ? ' active' : '') : '' }}"
                                    data-module-id="{{ $moduleid }}"
                                >
                                    <div class="icon-view">
                                        @if($moduleid == "notifications")
                                            <span>
                                                {{ $module["data"] }}
                                            </span>
                                        @endif

                                        {!! $module["icon"] !!}
                                    </div>

                                    <div class="text-view">
                                        {!! $module["title"] !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="maincontent" class="w-100 h-100">
                <div class="overlayer">
                    <div class="loader">
                        <svg class="circular" height="50" width="50">
                            <circle class="path" cx="25" cy="25.2" r="19.9" fill="none" stroke-width="6" stroke-miterlimit="10" />
                        </svg>
                    </div>
                </div>

                @php
                    $rootViewPath = "Centauri::Backend.Partials.Header";

                    $items = [
                        "caches",
                        "settings"
                    ];

                    $tabs = [];

                    foreach($items as $item) {
                        $tabs[$item] = [
                            "tabContentHTML" => view("$rootViewPath.Items.$item")->render(),
                            "dropdownContentHTML" => view("$rootViewPath.Content.$item")->render()
                        ];
                    }
                @endphp

                <section id="header" class="fancy-dropdown">
                    <a href="#0" class="nav-trigger">
                        Open Nav

                        <span aria-hidden="true"></span>
                    </a>

                    <nav class="main-nav">
                        <div class="row">
                            @foreach($tabs as $key => $tab)
                                <div class="col has-dropdown" data-content="{{ $key }}">
                                    {!! $tab["tabContentHTML"] !!}
                                </div>
                            @endforeach
                        </div>
                    </nav>
                    
                    <div class="fancy-dropdown-wrapper">
                        <div class="dropdown-list">
                            <div class="row">
                                @foreach($tabs as $key => $tab)
                                    <div id="{{ $key }}" class="dropdown">
                                        <div class="content">
                                            {!! $tab["dropdownContentHTML"] !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bg-layer" aria-hidden="true"></div>
                        </div>
                    </div>
                </section>

                {{-- <section id="header">
                    <div class="container h-100">
                        <div class="row h-100">
                            

                            <div class="col-8">
                                <div class="text-right">
                                    <a role="button" class="btn btn-primary btn-floating fa-lg waves-effect waves-light" data-dropdown="tools">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>

                                    <a role="button" class="btn btn-info btn-floating fa-lg waves-effect waves-light" data-dropdown="user">
                                        {{ Str::ucfirst(Str::substr($data["beuser"]->getAttribute("username"), 0, 1)) }}                                        <i class="fas fa-user-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> --}}

                <section id="content" class="h-100"></section>
            </section>

            <div id="editor">
                <div class="top p-3">
                    <p></p>
                </div>

                <div class="bottom">
                    <form action="" method="POST"></form>
                    {{-- <div class="col-12"></div> --}}
                </div>

                <div class="footer ci-bs-1">
                    <div class="container">
                        <div class="d-flex float-right">
                            <button style="left: -7.5px;" class="btn btn-success waves-effect waves-light" data-id="save" data-trigger="SaveEditorComponent" style="">
                                <i class="fas fa-save fa-lg mr-1" aria-hidden="true"></i>

                                Save
                            </button>

                            <button class="btn btn-danger waves-effect waves-light" data-id="cancel" data-trigger="CloseEditorComponent" style="">
                                <i class="fas fa-times fa-lg mr-1" aria-hidden="true"></i>

                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <script src="{{ asset('public/backend/js/centauri.min.js') }}" async defer></script> --}}

        <script src="{{ \Centauri\CMS\Helper\GulpRevHelper::include(
            \Centauri\CMS\Utility\PathUtility::getAbsURL("public/backend"),
            "js",
            "centauri.min.js"
        ) }}" async defer></script>

        <script src="{{ asset('resources/js/centauri-env.js') }}" async defer></script>

        <script>
            var Centauri__trans = {!! $data["localizedArr"] !!}
        </script>
    </body>
</html>

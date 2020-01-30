<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Centauri CMS » {{ $title ?? "" }}</title>
        <link rel="stylesheet" href="{{ asset('public/css/centauri.min.css') }}">
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

                            <br/>

                            <small>
                                v1.0.1

                                <small>
                                    <i>EA 1</i>
                                </small>
                            </small>
                        </h4>
                    </div>

                    <div id="modules" class="mt-5">
                        @foreach($data["modules"] as $moduleid => $module)
                            <div class="module waves-effect waves-light{{ isset($data['moduleid']) ? ($data['moduleid'] == $moduleid ? ' active' : '') : '' }}" data-module-id="{{ $moduleid }}">
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
                        @endforeach
                    </div>

                    <div id="user">
                        <div class="d-flex">
                            <div class="avatar-view">
                                <span>
                                    A
                                </span>
                            </div>

                            <div class="text-view">
                                <p class="m-0">
                                    Admin
                                </p>

                                <p class="m-0">
                                    Administrator
                                </p>

                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="dropdown-view" style="display: none;">
                            <div class="col mt-2">
                                <div class="position-relative">
                                    <select class="pt-4 mdb-select md-form m-0" id="language">
                                        <option value="en"{{ (app()->getLocale() == "en") ? " selected" : "" }}>
                                            English
                                        </option>

                                        <option value="de"{{ (app()->getLocale() == "de") ? " selected" : "" }}>
                                            Deutsch
                                        </option>
                                    </select>

                                    <label class="mdb-main-label" for="language" style="color:white; left:0;">
                                        @lang("backend/global.label_language")
                                    </label>
                                </div>

                                <a role="button" class="btn btn-danger waves-effect waves-light mt-2 ml-0 w-100" href="{{ url('centauri/action/Backend/logout') }}">
                                    Abmelden
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <section id="maincontent" class="w-100 h-100">
                <div class="overlayer">
                    <div class="preloader-wrapper active loader hidden">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>

                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>

                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-none">
                        <div class="loader hidden">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <section id="header">
                    <div class="container position-relative">
                        <div class="row h-100 align-items-center">
                            <div class="col col-md-8">
                                <div class="row">
                                    <div class="col">
                                        
                                    </div>

                                    <div class="row mx-0 text-right">
                                        <div class="tool waves-effect waves-light" data-type="cache">
                                            <div class="icon-view">
                                                <i class="fas fa-bolt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col col-md-4">
                                <div class="mt-2 md-form">
                                    <input id="global_search" class="form-control" type="text">

                                    <label for="global_search">
                                        Search
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="blocks z-depth-3">
                            <div class="block" data-type="cache">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="m-0">
                                            Caching
                                        </h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col item py-3">
                                        <a href="#" role="button" class="m-0 w-100 btn btn-success waves-effect waves-light" data-ajax="true" data-ajax-handler="Cache" data-ajax-action="flushFrontend">
                                            Flush Frontend Cache
                                        </a>
                                    </div>

                                    <div class="col item py-3">
                                        <a href="#" role="button" class="m-0 w-100 btn btn-success waves-effect waves-light" data-ajax="true" data-ajax-handler="Cache" data-ajax-action="flushBackend">
                                            Flush Backend Cache
                                        </a>
                                    </div>
                                </div>

                                <div class="col item px-0">
                                    <a href="#" role="button" class="m-0 w-100 btn btn-danger waves-effect waves-light" data-ajax="true" data-ajax-handler="Cache" data-ajax-action="flushAll">
                                        Flush All (System) Cache
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="content" class="h-100"></section>
            </section>

            <div id="editor">
                <div class="top p-3 peach-gradient">
                    <p></p>
                </div>
            
                <div class="bottom">
                    <div class="p-2">
                        <form action="" method="POST"></form>
                    </div>

                    <div class="row m-0 p-3 w-100">
                        <button class="col btn btn-success waves-effect waves-light px-2 py-3" data-id="save" data-trigger="SaveEditorComponent" style="">
                            <i class="fas fa-save fa-lg mr-1" aria-hidden="true"></i>

                            Save
                        </button>

                        <button class="col btn btn-danger waves-effect waves-light px-2 py-3" data-id="cancel" data-trigger="CloseEditorComponent" style="">
                            <i class="fas fa-times fa-lg mr-1" aria-hidden="true"></i>

                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('public/js/centauri.min.js') }}"></script>
        <script src="{{ asset('resources/js/centauri-env.js') }}"></script>

        <script>
            Centauri.__trans = {!! $data["localizedArr"] !!}
        </script>
    </body>
</html>

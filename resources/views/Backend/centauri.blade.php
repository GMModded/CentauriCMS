<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Centauri - Login</title>
        {{-- <script src="https://kit.fontawesome.com/20ea993ef1.js" crossorigin="anonymous"></script> --}}
        <link rel="stylesheet" href="{{ asset('public/css/centauri.min.css') }}">
    </head>

    <body>
        <div id="app">
            <section id="dashboard">
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
                        <div class="module waves-effect waves-light{{ isset($data['module']) ? ($data['module']['moduleid'] == $moduleid ? ' active' : '') : '' }}" data-module-id="{{ $moduleid }}">
                            <div class="icon-view">
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
                        <div class="item">
                            <div class="icon-view">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#758CA3" fill-rule="evenodd" d="M12,3 C9.790861,3 8,4.790861 8,7 C8,9.209139 9.790861,11 12,11 C14.209139,11 16,9.209139 16,7 C16,4.790861 14.209139,3 12,3 Z M12,1 C15.3137085,1 18,3.6862915 18,7 C18,10.3137085 15.3137085,13 12,13 C8.6862915,13 6,10.3137085 6,7 C6,3.6862915 8.6862915,1 12,1 Z M4,22.0990195 C4,22.6513043 3.55228475,23.0990195 3,23.0990195 C2.44771525,23.0990195 2,22.6513043 2,22.0990195 L2,20 C2,17.2385763 4.23857625,15 7,15 L17.0007003,15 C19.7621241,15 22.0007003,17.2385763 22.0007003,20 L22.0007003,22.0990195 C22.0007003,22.6513043 21.5529851,23.0990195 21.0007003,23.0990195 C20.4484156,23.0990195 20.0007003,22.6513043 20.0007003,22.0990195 L20.0007003,20 C20.0007003,18.3431458 18.6575546,17 17.0007003,17 L7,17 C5.34314575,17 4,18.3431458 4,20 L4,22.0990195 Z"></path></svg>
                            </div>

                            <div class="text-view">
                                <p class="m-0">
                                    Dein Profil
                                </p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="icon-view">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#758CA3" fill-rule="evenodd" d="M20.5857864,13 L5,13 C4.44771525,13 4,12.5522847 4,12 C4,11.4477153 4.44771525,11 5,11 L20.5857864,11 L18.2928932,8.70710678 C17.9023689,8.31658249 17.9023689,7.68341751 18.2928932,7.29289322 C18.6834175,6.90236893 19.3165825,6.90236893 19.7071068,7.29289322 L23.7071068,11.2928932 C24.0976311,11.6834175 24.0976311,12.3165825 23.7071068,12.7071068 L19.7071068,16.7071068 C19.3165825,17.0976311 18.6834175,17.0976311 18.2928932,16.7071068 C17.9023689,16.3165825 17.9023689,15.6834175 18.2928932,15.2928932 L20.5857864,13 Z M14,7 C14,7.55228475 13.5522847,8 13,8 C12.4477153,8 12,7.55228475 12,7 L12,4.69425418 C12,4.20541502 11.646587,3.78822491 11.164399,3.70786025 L3.16439899,2.37452692 C2.61962867,2.28373187 2.10440113,2.65175153 2.01360608,3.19652186 C2.00455084,3.25085328 2,3.30583998 2,3.36092084 L2,20.6390792 C2,21.1913639 2.44771525,21.6390792 3,21.6390792 C3.05508086,21.6390792 3.11006756,21.6345283 3.16439899,21.6254731 L11.164399,20.2921397 C11.646587,20.2117751 12,19.794585 12,19.3057458 L12,17 C12,16.4477153 12.4477153,16 13,16 C13.5522847,16 14,16.4477153 14,17 L14,19.3057458 C14,20.7722633 12.9397609,22.0238336 11.493197,22.2649276 L3.49319696,23.5982609 C3.33020268,23.6254266 3.16524258,23.6390792 3,23.6390792 C1.34314575,23.6390792 3.55271368e-15,22.2959334 0,20.6390792 L0,3.36092084 C0,3.19567826 0.0136525156,3.03071816 0.0408182285,2.86772388 C0.313203389,1.23341292 1.858886,0.129353911 3.49319696,0.401739072 L11.493197,1.73507241 C12.9397609,1.97616639 14,3.22773672 14,4.69425418 L14,7 Z"></path></svg>
                            </div>

                            <div class="text-view">
                                <p class="m-0">
                                    <a href="{{ url('centauri/de') }}">Deutsch</a>
                                    <a href="{{ url('centauri/en') }}">English</a>
                                </p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="icon-view">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#758CA3" fill-rule="evenodd" d="M20.5857864,13 L5,13 C4.44771525,13 4,12.5522847 4,12 C4,11.4477153 4.44771525,11 5,11 L20.5857864,11 L18.2928932,8.70710678 C17.9023689,8.31658249 17.9023689,7.68341751 18.2928932,7.29289322 C18.6834175,6.90236893 19.3165825,6.90236893 19.7071068,7.29289322 L23.7071068,11.2928932 C24.0976311,11.6834175 24.0976311,12.3165825 23.7071068,12.7071068 L19.7071068,16.7071068 C19.3165825,17.0976311 18.6834175,17.0976311 18.2928932,16.7071068 C17.9023689,16.3165825 17.9023689,15.6834175 18.2928932,15.2928932 L20.5857864,13 Z M14,7 C14,7.55228475 13.5522847,8 13,8 C12.4477153,8 12,7.55228475 12,7 L12,4.69425418 C12,4.20541502 11.646587,3.78822491 11.164399,3.70786025 L3.16439899,2.37452692 C2.61962867,2.28373187 2.10440113,2.65175153 2.01360608,3.19652186 C2.00455084,3.25085328 2,3.30583998 2,3.36092084 L2,20.6390792 C2,21.1913639 2.44771525,21.6390792 3,21.6390792 C3.05508086,21.6390792 3.11006756,21.6345283 3.16439899,21.6254731 L11.164399,20.2921397 C11.646587,20.2117751 12,19.794585 12,19.3057458 L12,17 C12,16.4477153 12.4477153,16 13,16 C13.5522847,16 14,16.4477153 14,17 L14,19.3057458 C14,20.7722633 12.9397609,22.0238336 11.493197,22.2649276 L3.49319696,23.5982609 C3.33020268,23.6254266 3.16524258,23.6390792 3,23.6390792 C1.34314575,23.6390792 3.55271368e-15,22.2959334 0,20.6390792 L0,3.36092084 C0,3.19567826 0.0136525156,3.03071816 0.0408182285,2.86772388 C0.313203389,1.23341292 1.858886,0.129353911 3.49319696,0.401739072 L11.493197,1.73507241 C12.9397609,1.97616639 14,3.22773672 14,4.69425418 L14,7 Z"></path></svg>
                            </div>

                            <div class="text-view">
                                <p class="m-0">
                                    <a href="{{ url('centauri/action/Backend/logout') }}">
                                        Abmelden
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

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

                    <div class="row m-0 p-3">
                        <button class="col btn btn-success waves-effect waves-light btn-floating" data-id="save" data-trigger="saveAllElements">
                            <i class="fas fa-save" aria-hidden="true"></i>
                        </button>

                        <button class="col btn btn-danger waves-effect waves-light btn-floating" data-id="cancel" data-trigger="CloseEditorComponent" style="">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var centauriJsFile = "@php echo asset('public/js/centauri.min.js'); @endphp";
            var centauriEnvJsFile = "@php echo asset('resources/js/centauri-env.js'); @endphp";

            if(document.getElementById("centauriscript") == null && typeof Centauri == "undefined") {
                centauriScript = document.createElement("script");
                centauriScript.src = centauriJsFile;
                document.getElementsByTagName("body")[0].appendChild(centauriScript);

                centauriEnvScript = document.createElement("script");
                centauriEnvScript.src = centauriEnvJsFile;
                document.getElementsByTagName("body")[0].appendChild(centauriEnvScript);
            }
        </script>
    </body>
</html>

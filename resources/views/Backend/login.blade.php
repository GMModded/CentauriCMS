<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Centauri - Login</title>
        <script src="https://kit.fontawesome.com/20ea993ef1.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('public/css/mdb.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/centauri.min.css') }}">
    </head>

    <body>
        <div class="overlayer"></div>

        <style>
            *::selection {
                background: transparent !important;
            }

            h1, h2, h3, h4, h5, h6, a, p, span, input:not([placeholder]) {
                text-shadow: 0 0 35px #0a0a0a;
            }

            ::placeholder {
                opacity: .5 !important;
                color: white !important;
            }

            body {
                background-image: url(https://images.pexels.com/photos/36717/amazing-animal-beautiful-beautifull.jpg?auto=compress&cs=tinysrgb&h=750&w=1260);
                background-size: cover;
                overflow: hidden;
                background-repeat: no-repeat;
                background-position: center;
                position: relative;
            }

            .overlayer {
                position: absolute;
                top: 0;
                left: 0;
                background: rgba(0, 0, 0, .4167);
                width: 100%;
                height: 100%;
                z-index: -1;
            }

            body > .container {
                color: white;
                height: 100vh;
                padding-top: 12.5% !important;
            }

            body > .container > .row {
                position: relative;
                padding: 120px 30px;
                background: linear-gradient(40deg, #d03856 50%, #ffd700 100%) !important;
                border-radius: 3px;
                box-shadow: 0 0 35px #1f1f1f;
            }

            .badge {
                position: absolute;
                top: -15px;
                right: -15px;
                border-radius: 3px;
                display: block !important;
                width: 60px;
                height: 60px;
                background: linear-gradient(40deg, #d03856 25%, #ffd700 85%) !important;
                box-shadow: 0 0 15px #282842;
            }

            .badge i {
                font-size: 24px;
                padding: 15px;
                text-align: center;
            }

            #login input {
                background-color: transparent !important;
                box-shadow: none !important;
                outline: none !important;
                border: 1px solid white;
                color: white;
            }


            .centauri-notifications {
                position: absolute;
                top: 20px;
                right: 20px;
                bottom: auto;
                left: auto;
                width: 400px;
                z-index: 99;
                max-height: calc(100% - 20px);
                overflow: hidden;
            }
            
            .centauri-notifications .item {
                font-family: Source Sans Pro, Helvetica Neue, Helvetica, Arial, sans-serif;
                -webkit-font-smoothing: antialiased;
                box-sizing: border-box;
                padding: 0;
                border-radius: 4px;
                color: #52667a;
                text-align: left;
                position: relative;
                margin: 0 auto 20px;
                font-size: 14px;
                box-shadow: 1px 2px 5px rgba(0, 0, 0, .1);
                border: 1px solid #d1d9e0;
                border-left-width: 4px;
                width: 100%;
                background-color: #fff;
                border-color: #d1d9e0 #d1d9e0 #d1d9e0 #de294c;
                animation: centauri-animation-slidein .5s;
            }
            
            .centauri-notifications .item[data-layout="error"] svg path {
                fill: #de294c;
            }
            
            .centauri-notifications .item svg {
                font-family: Source Sans Pro, Helvetica Neue, Helvetica, Arial, sans-serif;
                -webkit-font-smoothing: antialiased;
                text-align: left;
                font-size: 14px;
                box-sizing: border-box;
                margin: 0;
                padding: 0;
                vertical-align: middle;
                line-height: 0;
                position: absolute;
                display: block;
                left: 15px;
                top: 15px;
                color: #de294c;
                width: 20px;
                height: 20px;
            }

            @keyframes centauri-animation-slidein {
                0% {
                    margin-left: 120px;
                    opacity: 0;
                }

                100% {
                    margin-left: 0px;
                    opacity: 1;
                }
            }
        </style>

        <div class="centauri-notifications"></div>

        <div class="container p-0">
            <div class="row">
                <div class="col-6 d-none d-md-block">
                    <h1>Welcome to <b>Centauri</b></h1>
                    <h5>Log in to access the backend</h5>

                    <hr style="margin: 2rem 0;">

                    <p>
                        Forgot password?

                        <a href="lel" style="color: gold; text-decoration: underline; display: block;">
                            Reset by mail!
                        </a>
                    </p>
                </div>

                <div class="badge">
                    <i class="fas fa-rocket"></i>
                </div>

                <div id="login" class="col-12 col-md-6 align-self-center">
                    <div class="py-4 px-5">
                        <h4 class="mb-4">
                            <u>
                                Centauri - Login
                            </u>
                        </h4>

                        <form action="centauri/login" method="post">
                            @csrf

                            <input class="form-control mb-3" type="text" name="username" id="username" placeholder="Username" />
                            <input class="form-control mb-4" type="password" name="password" id="password" placeholder="Password" />

                            <div class="row">
                                <div class="col-6 ml-auto mt-2">
                                    <span class="d-block waves-effect waves-light">
                                        <input class="btn btn-default w-100 m-0" type="submit" value="Login" />
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script id="centauriscript" src="{{ asset('public/js/centauri.min.js') }}"></script>
    </body>
</html>

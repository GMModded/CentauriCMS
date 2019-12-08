<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>CentauriCMS Installer</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link href="{{ asset('Centauri/CMS/Views/css/centauri.min.css') }}" rel="stylesheet">
    </head>

    <body>
        <div id="centauri-installer">
            <div class="container">
                <form method="POST">
                    @csrf

                    <input type="hidden" name="step" value="1" />

                    <div class="row">
                        <div class="col-12 content py-4 mt-5 mb-4">
                            <h2>
                                Centauri CMS
                            </h2>

                            <hr>

                            <h5>
                                Installing Centauri CMS {VERSION}
                            </h5>

                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                            </div>

                            <select name="test">
                                <option value="a">a</option>
                            </select>
                        </div>

                        <div class="col-12 text-right">
                            <input type="submit" value="Continue" class="btn btn-success" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

<div class="col-12 px-3">
    <div class="row">
        <div class="col-6">
            Application Context:
        </div>

        <div class="col-6">
            {{ Centauri\CMS\Centauri::getApplicationContext() }}
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            Server-Software:
        </div>

        <div class="col-6">
            {{ $_SERVER["SERVER_SOFTWARE"] }}
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            PHP-Version:
        </div>

        <div class="col-6">
            {{ PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION . "." . PHP_RELEASE_VERSION }}
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            DB-Version:
        </div>

        <div class="col-6">
            {{ DB::connection(config("database")["default"])->getPdo()->getAttribute(4) }}
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            OS:
        </div>

        <div class="col-6">
            {{ php_uname("s") . " - " . php_uname("r") . " - " . php_uname("m") }}
        </div>
    </div>
</div>

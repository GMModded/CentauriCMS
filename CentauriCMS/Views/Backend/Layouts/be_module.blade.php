<section id="module_{{ e($__env->yieldContent('moduleid')) }}">
    <div class="container">
        <div class="row mb-3">
            <div class="col align-items-center d-flex">
                <h3 id="title">
                    <span class="d-none d-lg-inline-block">Centauri</span>
                    » 
                    @yield("headertitle")
                </h3>
            </div>

            <div class="col col-md-4">
                <div class="md-form">
                    <input id="filter" class="form-control" type="text" />

                    <label for="filter">
                        @lang("backend/centauri.search")
                    </label>
                </div>
            </div>
        </div>

        @if(isset($data["__notification"]))
            @php
                $alertclass = "";
                $iconclass = "";

                switch($data["__notification"]["severity"]) {
                    case "ERROR":
                        $alertclass = "danger";
                        $iconclass = "fas fa-exclamation-triangle";
                        break;
                    case "WARN":
                        $alertclass = "warning";
                        $iconclass = "fas fa-exclamation-circle";
                        break;
                    default:
                        break;
                }
            @endphp

            <div class="alert alert-{{ $alertclass }}" role="alert">
                <div class="row">
                    <div class="col icon-view">
                        <i class="{{ $iconclass }} mr-2"></i>
                    </div>

                    <div class="col text-view">
                        <h6>
                            {{ $data["__notification"]["title"] }}
                        </h6>

                        <p class="m-0">
                            {{ $data["__notification"]["text"] }}
                        </p>

                        {!! $data["__notification"]["html"] !!}
                    </div>
                </div>
            </div>
        @endif
    </div>

    @yield("content")
</section>

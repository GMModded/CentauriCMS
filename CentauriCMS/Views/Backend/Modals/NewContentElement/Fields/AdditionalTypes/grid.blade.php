<ul class="nav nav-tabs md-tabs" id="grid-tabs" role="tablist" style="width: calc(100% - 30px);">
    <li class="nav-item waves-effect waves-light">
        <a href="#grid-tab-content" class="nav-link active" id="alb-grid-tab-content" data-toggle="tab" aria-controls="grid-tab-content">
            Content Elements
        </a>
    </li>

    <li class="nav-item waves-effect waves-light">
        <a href="#grid-tab-config" class="nav-link" id="alb-grid-tab-config" data-toggle="tab" aria-controls="grid-tab-config">
            Configuration
        </a>
    </li>
</ul>

<div class="tab-content card pt-5">
    <div class="tab-pane fade show active" id="grid-tab-content" role="tabpanel" aria-labelledby="alb-grid-tab-content"></div>

    <div class="tab-pane fade" id="grid-tab-config" role="tabpanel" aria-labelledby="alb-grid-tab-config">
        <div class="row">
            <div class="col-12">
                <div class="col-12 col-lg-3">
                    <label for="data-grid" class="form-check-label active" style="top: 0;">
                        Layout
                    </label>

                    <select class="mdb-select md-form" id="grid" data-id="grid" data-uid="{{ $fieldConfig['uid'] }}" required>
                        <option value="" selected disabled>
                            Select a grid
                        </option>

                        @if(isset($additionalData))
                            @foreach($additionalData["grids"] as $label => $value)
                                @if($fieldConfig["value"] == $value)
                                    <option value="{{ $value }}" selected>
                                        {{ $label }}
                                    </option>
                                @else
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="container_fullwidth" data-id="container_fullwidth">

                    <label class="form-check-label" for="container_fullwidth">
                        Container Full-Width?
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

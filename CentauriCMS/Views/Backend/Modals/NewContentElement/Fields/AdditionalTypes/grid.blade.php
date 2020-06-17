<ul class="nav nav-tabs" id="grid-tabs" role="tablist" style="width: calc(100% - 30px);">
    <li class="nav-item waves-effect waves-light active" data-tab-id="grids-tab-ces">
        Content Elements
    </li>

    <li class="nav-item waves-effect waves-light" data-tab-id="grids-tab-config">
        Configuration
    </li>
</ul>

<div class="tab-content card pt-5">
    <div class="tab-pane fade show active" data-tab-id="grids-tab-ces"></div>

    <div class="tab-pane fade" data-tab-id="grids-tab-config">
        <div class="row">
            <div class="col-12 col-lg ci-field">
                <label for="data-grid" class="form-check-label active" style="top: 0;">
                    Layout
                </label>

                <select class="select-wrapper mdb-select md-form mt-1" id="grid" data-id="grid" data-uid="{{ $fieldConfig['uid'] }}" required>
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

            <div class="col-12 col-lg ci-field">
                <select class="mdb-select md-form" data-id="grid_space_top" data-uid="{{ $fieldConfig['uid'] }}">
                    <option value="" selected>
                        Top Space
                    </option>

                    @for($i = 1; $i != 6; $i++)
                        <option value="mt-{{ $i }}">
                            MT-{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-12 col-lg ci-field">
                <div class="form-check pl-0 md-form">
                    <input class="form-check-input" type="checkbox" id="grid_container_fullwidth" data-id="grid_container_fullwidth" data-uid="{{ $fieldConfig['uid'] }}" data-inline-record="{{ isset($fieldConfig['isInlineRecord']) ? $fieldConfig['isInlineRecord'] : '0' }}" checked="{{ !is_null($element) ? $element->grid_container_full_width : 0 }}">

                    <label class="form-check-label" for="grid_container_fullwidth">
                        Container Full-Width?
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg ci-field">
                <select class="mdb-select md-form" data-id="grid_space_left" data-uid="{{ $fieldConfig['uid'] }}">
                    <option value="" selected>
                        Left Space
                    </option>

                    @for($i = 1; $i != 6; $i++)
                        <option value="pl-{{ $i }}">
                            PL-{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-12 col-lg ci-field">
                <select class="mdb-select md-form" data-id="grid_space_bottom" data-uid="{{ $fieldConfig['uid'] }}">
                    <option value="" selected>
                        Bottom Space
                    </option>

                    @for($i = 1; $i != 6; $i++)
                        <option value="mb-{{ $i }}">
                            MB-{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-12 col-lg ci-field">
                <select class="mdb-select md-form" data-id="grid_space_right" data-uid="{{ $fieldConfig['uid'] }}">
                    <option value="" selected>
                        Right Space
                    </option>

                    @for($i = 1; $i != 6; $i++)
                        <option value="pr-{{ $i }}">
                            PR-{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
</div>

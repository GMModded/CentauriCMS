<div class="col-12 col-lg-3">
    <h6 class="mb-n4">
        Config
    </h6>

    <div class="row">
        <div class="col-12">
            <select class="mdb-select md-form" data-id="grid" data-uid="{{ $fieldConfig['uid'] }}" required>
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

            <div class="form-check pl-0">
                <input type="checkbox" class="form-check-input" id="container_fullwidth" data-id="container_fullwidth">

                <label class="form-check-label" for="container_fullwidth">
                    Container Full-Width?
                </label>
            </div>
        </div>
    </div>
</div>

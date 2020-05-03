<div class="col-12 col-lg-3">
    <h6 class="mb-n4">
        Config
    </h6>

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
</div>

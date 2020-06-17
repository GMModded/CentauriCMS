<div class="row">
    <div class="col-12 col-md-3">
        <div class="ci-field">
            <select data-id="grid" required>
                <option value="" selected disabled>
                    Column-Width of Container
                </option>

                @if(isset($fieldConfig["additionalData"]))
                    @foreach($fieldConfig["additionalData"]["grids"] as $label => $value)
                        <option value="{{ $value }}">
                            {{ $label }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="col">
        
    </div>
</div>

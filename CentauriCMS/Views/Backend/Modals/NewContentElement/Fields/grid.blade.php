<div class="row">
    <div class="col-12 col-md-3">
        <select class="mdb-select md-form" data-id="grid" required>
            <option value="" selected disabled>
                Select a grid
            </option>

            @if(isset($additionalData))
                @foreach($additionalData["grids"] as $gridId => $gridArr)
                    @foreach($gridArr as $label => $value)
                        @if($value ?? "" == $value)
                            <option value="{{ $value }}" selected>
                                {{ $label }}
                            </option>
                        @else
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endif
                    @endforeach
                @endforeach
            @endif
        </select>
    </div>

    <div class="col">
        
    </div>
</div>

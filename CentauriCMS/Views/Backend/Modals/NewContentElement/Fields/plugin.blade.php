<div class="ci-field">
    <select data-id="plugin" data-uid="{{ $fieldConfig['uid'] }}" required>
        <option value="" selected disabled>
            Select a plugin
        </option>

        @if(!is_null($additionalData))
            @foreach($additionalData["plugins"] as $key => $arr)
                @foreach($arr as $label => $namespace)
                    @if($namespace == $fieldConfig["value"])
                        <option value="{{ $fieldConfig['value'] }}" selected>
                            {{ $label }}
                        </option>
                    @else
                        @if($fieldConfig["value"] != "")
                            <option value="null" selected>
                                >> Plugin '{{ $fieldConfig["value"] }}' not found!
                            </option>
                        @else
                            <option value="{{ $namespace }}">
                                {{ $label }}
                            </option>
                        @endif
                    @endif
                @endforeach
            @endforeach
        @endif
    </select>
</div>

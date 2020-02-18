<select class="mdb-select md-form" data-id="plugin" required>
    <option value="" selected disabled>
        Select a plugin
    </option>

    @if(isset($fieldConfig["additionalData"]))
        @foreach($fieldConfig["additionalData"]["plugins"] as $pluginId => $pluginArr)
            @foreach($pluginArr as $pluginLabel => $pluginValue)
                @if($value ?? "" == $pluginValue)
                    <option value="{{ $pluginValue }}" selected>
                        {{ $pluginLabel }}
                    </option>
                @else
                    <option value="{{ $pluginValue }}">
                        {{ $pluginLabel }}
                    </option>
                @endif
            @endforeach
        @endforeach
    @endif
</select>

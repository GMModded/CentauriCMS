<select class="mdb-select md-form" data-id="plugin" data-uid="{{ $fieldConfig['uid'] }}" required>
    <option value="" selected disabled>
        Select a plugin
    </option>

    @if(!is_null($additionalData))
        @foreach($additionalData["plugins"] as $pluginId => $pluginArr)
            @foreach($pluginArr as $pluginLabel => $pluginNamespace)
                @if(!isset($additionalData["plugins"][$fieldConfig["value"]]))
                    <option value="null" selected>
                        >> Plugin '{{ $fieldConfig["value"] }}' not found!
                    </option>
                @endif

                @if($fieldConfig["value"] == $pluginId)
                    <option value="{{ $pluginId }}" selected>
                        {{ $pluginLabel }}
                    </option>
                @else
                    <option value="{{ $pluginId }}">
                        {{ $pluginLabel }}
                    </option>
                @endif
            @endforeach
        @endforeach
    @endif
</select>

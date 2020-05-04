<div class="md-form">
    <label for="{{ $fieldConfig['id'] }}"{{ ((isset($fieldConfig["value"]) || isset($fieldConfig["config"]["default"]) || (!empty($fieldConfig["config"]["items"]))) ? " class=active" : "") }}>
        {{ $fieldConfig["label"] }}
    </label>

    <select class="mdb-select md-form" data-id="{{ $fieldConfig['id'] }}"{{ $fieldConfig["config"]["required"] ? " required" : ""}} data-uid="{{ $fieldConfig['uid'] }}">
        @if(isset($fieldConfig["config"]["default"]))
            <option value="{{ $fieldConfig["config"]["default"][1] }}" selected disabled>
                {{ $fieldConfig["config"]["default"][0] }}
            </option>
        @endif

        @foreach($fieldConfig["config"]["items"] as $item)
            @if($item[0] == ($value ?? ""))
                <option value="{{ $item[1] }}" selected>
                    {{ $item[0] }}
                </option>
            @else
                <option value="{{ $item[1] }}">
                    {{ $item[0] }}
                </option>
            @endif
        @endforeach
    </select>
</div>

<div class="ci-field">
    <select class="ci-select" id="{{ $fieldConfig['id'] }}"{{ isset($fieldConfig["config"]["required"]) ? " required" : ""}} data-uid="{{ $fieldConfig['uid'] }}">
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

    <label>
        {{ $fieldConfig["label"] }}
    </label>

    <i class="fas fa-chevrolet-down"></i>

    <label class="sel-label" for="{{ $fieldConfig['id'] }}">
        @if(isset($fieldConfig["value"]) && ($fieldConfig["value"] != ""))
            {{ $fieldConfig["value"] }}
        @else
            {{ $fieldConfig["defaultLabel_noValue"] ?? "Choose an option" }}
        @endif
    </label>
</div>

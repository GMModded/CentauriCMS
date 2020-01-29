<div class="md-form">
    <label for="{{ $id }}"{{ ((isset($value) || isset($config["default"]) || (!empty($config["items"]))) ? " class=active" : "") }}>
        {{ $label }}
    </label>

    <select class="mdb-select md-form" data-id="{{ $id }}"{{ $config["required"] ? " required" : ""}}>
        @if(isset($config["default"]))
            <option value="{{ $config["default"][1] }}" selected disabled>
                {{ $config["default"][0] }}
            </option>
        @endif

        @foreach($config["items"] as $item)
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

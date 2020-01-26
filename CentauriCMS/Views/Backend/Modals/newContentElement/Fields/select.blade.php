<div class="md-form">
    <label for="{{ $id }}"{{ (isset($value) ? ' class=active' : '') }}>
        {{ $label }}
    </label>

    <select class="mdb-select md-form" data-id="{{ $id }}">
        @if(isset($config["default"]))
            <option value="{{ $config["default"]["value"] }}" selected disabled>
                {{ $config["default"]["label"] }}
            </option>
        @endif

        @foreach($config["items"] as $item)
            @if($item["value"] == $value)
                <option value="{{ $item["value"] }}" selected>
                    {{ $item["label"] }}
                </option>
            @else
                <option value="{{ $item["value"] }}">
                    {{ $item["label"] }}
                </option>
            @endif
        @endforeach
    </select>
</div>

<div class="ci-field">
    <div class="file-field d-flex mt-2">
        <button class="input-group-text btn btn-primary waves-effect waves-light p-3 mx-0 mt-3 mr-2" data-centauri-btn="addfile" data-required="{{ $fieldConfig['config']['required'] ?? '' }}" data-maxitems="{{ $fieldConfig['config']['maxItems'] ?? '' }}">
            <i class="fas fa-file mr-2"></i>

            Add file
        </button>

        <button class="input-group-text btn btn-primary waves-effect waves-light p-3 mx-0 mt-3" data-centauri-btn="uploadfile" data-required="{{ $fieldConfig['config']['required'] ?? '' }}" data-maxitems="{{ $fieldConfig['config']['maxItems'] ?? '' }}">
            <i class="fas fa-cloud-upload-alt mr-2"></i>

            Upload file
        </button>
    </div>

    <input class="form-control d-none" type="text" data-id="{{ $fieldConfig['id'] }}" value="{{ $fieldConfig['value'] ?? '' }}" />

    <label for="{{ $fieldConfig['id'] }}"{{ (isset($fieldConfig['value']) ? ' class=active' : '') }} style="margin-top: -25px;">
        {{ $fieldConfig["label"] }}
    </label>

    <div class="accordions inline-records mt-2" data-type="{{ $fieldConfig['id'] }}">
        @php
            if(isset($value) && ($value != "")) {

                if(Str::contains($value, ",")) {
                    $value = explode(",", $value);
                } else {
                    $value = [$value];
                }

                $splittedUids = $value;
            }
        @endphp

        @if(isset($splittedUids))
            @foreach($splittedUids as $imgUid)
                <div class="accordion p-3 ci-bs-1 mb-2">
                    <div class="top">
                        {{ Centauri\CMS\BladeHelper\ImageBladeHelper::get($imgUid)->name ?? "" }}
                    </div>

                    <div class="bottom" style="display:none;">
                        <img src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($imgUid) !!}" class="img-fluid mr-2" />
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@php
    $isInlineRecord = "0";

    if(isset($fieldConfig["isInlineRecord"])) {
        if($fieldConfig["isInlineRecord"]) {
            $isInlineRecord = "1";
        }
    }
@endphp

<div class="ci-field">
    <div class="image-field d-flex mt-2">
        <button class="input-group-text btn btn-primary waves-effect waves-light p-3 mx-0 mt-3 mr-2" data-centauri-btn="addimage" data-required="{{ $fieldConfig['required'] ?? '' }}" data-maxitems="{{ $fieldConfig['maxItems'] ?? '' }}" data-minitems="{{ $fieldConfig['minItems'] ?? '' }}">
            <i class="fas fa-images mr-2"></i>

            Add image
        </button>

        <button class="input-group-text btn btn-primary waves-effect waves-light p-3 mx-0 mt-3" data-centauri-btn="uploadimage" data-required="{{ $fieldConfig['required'] ?? '' }}" data-maxitems="{{ $fieldConfig['maxItems'] ?? '' }}" data-minitems="{{ $fieldConfig['minItems'] ?? '' }}">
            <i class="fas fa-cloud-upload-alt mr-2"></i>

            Upload image
        </button>
    </div>

    <input class="form-control d-none image-input" type="text" data-id="{{ $fieldConfig['id'] }}" value="{{ $fieldConfig['value'] ?? '' }}" data-inline-record="{{ $isInlineRecord }}" data-uid="{{ $fieldConfig['uid'] }}" />

    <label for="{{ $fieldConfig['id'] }}" style="margin-top: -25px;">
        {{ $fieldConfig['label'] }}
    </label>

    <div class="accordions inline-records mt-2" data-type="image">
        @php
            if(isset($fieldConfig["value"]) && ($fieldConfig["value"] != "")) {
                if(Str::contains($fieldConfig["value"], ",")) {
                    $fieldConfig["value"] = explode(",", $fieldConfig["value"]);
                } else {
                    $fieldConfig["value"] = [$fieldConfig["value"]];
                }

                $splittedUids = $fieldConfig["value"];
            }
        @endphp

        @if(isset($splittedUids))
            @foreach($splittedUids as $imgUid)
                <div class="accordion ci-bs-1 mb-2">
                    <div class="top">
                        {{ Centauri\CMS\BladeHelper\ImageBladeHelper::get($imgUid)->name ?? "" }}
                    </div>

                    <div class="bottom" style="display:none;">
                        <img src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($imgUid) !!}" class="img-fluid" />

                        {{-- <div class="ci-field">
                            <input type="text" name="image_height" data-id="image_height" value="{{ Centauri\CMS\BladeHelper\ImageBladeHelper::get($imgUid)->height }}" />
                        </div> --}}
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

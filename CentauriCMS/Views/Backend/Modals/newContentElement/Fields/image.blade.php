<div class="md-form">
    <div class="image-field d-flex mt-2">
        <button class="input-group-text md-addon btn btn-primary waves-effect waves-light p-3 mx-0 mt-3 mr-2" data-centauri-btn="addimage" data-required="{{ $config["required"] ?? '' }}" data-maxitems="{{ $config["maxItems"] ?? '' }}">
            <i class="fas fa-images mr-2"></i>

            Add image
        </button>

        <button class="input-group-text md-addon btn btn-primary waves-effect waves-light p-3 mx-0 mt-3" data-centauri-btn="uploadimage" data-required="{{ $config["required"] ?? '' }}" data-maxitems="{{ $config["maxItems"] ?? '' }}">
            <i class="fas fa-cloud-upload-alt mr-2"></i>

            Upload image
        </button>
    </div>

    <input class="form-control d-none image-input" type="text" id="{{ $id }}" data-id="{{ $id }}" value="{{ $value ?? '' }}" data-inline-record="1" />

    <label for="{{ $id }}" style="margin-top: -25px;">
        {{ $label }}
    </label>

    <div class="accordions inline-records mt-2" data-type="image">
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
                <div class="accordion z-depth-1 mb-2">
                    <div class="top">
                        {{ ImageBladeHelper::get($imgUid)->name ?? "" }}
                    </div>

                    <div class="bottom" style="display:none;">
                        <img src="{!! ImageBladeHelper::getPath($imgUid) !!}" class="img-fluid mr-2" />
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

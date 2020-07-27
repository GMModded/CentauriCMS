@php
    $isInlineRecord = "0";

    if(isset($fieldConfig["isInlineRecord"])) {
        if($fieldConfig["isInlineRecord"]) {
            $isInlineRecord = "1";
        }
    }

    $fileReferences = \Centauri\CMS\Model\FileReference::where("uid_element", $fieldConfig["uid"])->get()->all();
@endphp

<div class="ci-field">
    <div class="image-field d-flex mt-2">
        <button class="btn btn-primary waves-effect waves-light p-3 mx-0 mt-3 mr-2" data-centauri-btn="addimage">
            <i class="fas fa-images mr-2"></i>

            Add image
        </button>

        <button class="btn btn-primary waves-effect waves-light p-3 mx-0 mt-3" data-centauri-btn="uploadimage">
            <i class="fas fa-cloud-upload-alt mr-2"></i>

            Upload image
        </button>
    </div>

    <input 
        class="form-control d-none image-input"
        type="text"
        data-id="{{ $fieldConfig['id'] }}"
        value="{{ $fieldConfig['value'] ?? '' }}"
        data-inline-record="{{ $isInlineRecord }}"
        data-uid="{{ $fieldConfig['uid'] }}"
    />

    <label for="{{ $fieldConfig['id'] }}" style="margin-top: -25px;">
        {{ $fieldConfig['label'] }}
    </label>

    <div class="accordions inline-records mt-2" data-type="image">
        @if(isset($fileReferences) && !empty($fileReferences))
            @foreach($fileReferences as $fileReference)
                <div class="accordion ci-bs-1 mb-2">
                    <div class="top">
                        {{ Centauri\CMS\BladeHelper\ImageBladeHelper::get($fileReference->uid_image)->name ?? "" }}
                    </div>

                    <div class="bottom" style="display:none;">
                        <div class="row my-2">
                            <div class="col-12 col-lg-3">
                                <img 
                                    src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($fileReference->uid_image) !!}"
                                    class="img-fluid w-100"
                                    data-uid="{{ $fileReference->uid }}"
                                />
                            </div>

                            <div class="col-12 col-lg text-center">
                                <button class="btn btn-primary waves-effect waves-light p-3 mx-0 mt-3 mr-2" data-centauri-btn="cropimage">
                                    <i class="fas fa-crop-alt mr-2"></i>

                                    Cropper
                                </button>

                                <button class="btn btn-primary waves-effect waves-light p-3 mx-0 mt-3 mr-2" data-centauri-btn="focalpointerimage">
                                    <i class="fas fa-cut mr-2"></i>

                                    Focal-Pointer
                                </button>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-12 col-lg-6">
                                <div class="ci-field">
                                    <input 
                                        type="text"
                                        class="form-control"
                                        data-id="{{ $fieldConfig['id'] }}_title:{{ $fieldConfig['uid'] }}:{{ $fileReference->uid }}"
                                        value="{{ $fileReference->title ?? '' }}"
                                        data-uid="{{ $fileReference->uid }}"
                                    />

                                    <label for="{{ $fieldConfig['id'] }}_title"{{ (isset($fileReference->title) && (strlen($fileReference->title) > 0) ? " class=active" : "") }}>
                                        Title
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="ci-field">
                                    <input 
                                        type="text"
                                        class="form-control"
                                        data-id="{{ $fieldConfig['id'] }}_alt:{{ $fieldConfig['uid'] }}:{{ $fileReference->uid }}"
                                        value="{{ $fileReference->alt ?? '' }}"
                                        data-uid="{{ $fileReference->uid }}"
                                    />

                                    <label for="{{ $fieldConfig['id'] }}_alt"{{ (isset($fileReference->alt) && (strlen($fileReference->alt) > 0) ? " class=active" : "") }}>
                                        Alternative Text
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="ci-field">
                                    <textarea 
                                        type="text"
                                        class="form-control"
                                        data-id="{{ $fieldConfig['id'] }}_description:{{ $fieldConfig['uid'] }}:{{ $fileReference->uid }}"
                                        data-uid="{{ $fileReference->uid }}"
                                    >{{ $fileReference->description ?? '' }}</textarea>

                                    <label for="{{ $fieldConfig['id'] }}_description"{{ (isset($fileReference->description) && (strlen($fileReference->description) > 0) ? " class=active" : "") }}>
                                        Description
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

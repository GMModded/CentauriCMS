<div id="cropper">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 col-lg-8 h-100 px-lg-0">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <img id="cropped-image" class="img-fluid w-100" src="{{ $file->path }}" />
                </div>
            </div>

            <div id="cropper-panel" class="col-12 col-lg-4 h-100 position-relative">
                <div class="row">
                    <div class="col-12">
                        <div class="img-preview preview-lg"></div>

                        <div style="display: flex;justify-content: flex-end;position: absolute;right: 0;bottom: 15px;font-weight: bold;text-decoration: underline;color: white;background: rgba(0, 0, 0, .66);padding: 5px;">
                            <p id="cropper_imgsizes" style="font-weight: bold;float: right;margin: 0;display: block;"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg">
                        <div class="ci-field">
                            <input 
                                id="cropper_file_name"
                                data-id="cropper_file_name"
                                type="text"
                                class="form-control"
                                value="{{ $fileReference->title ?? '' }}"
                                required
                            />

                            <label 
                                for="cropper_file_name"
                                {{ $fileReference->title != "" ? 'class=active' : '' }}
                            >
                                Cropped Image Name
                            </label>
                        </div>
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-12 col-lg">
                        <div class="ci-field">
                            <input 
                                id="cropper_mediaquery_minwidth"
                                data-id="cropper_mediaquery_minwidth"
                                type="text"
                                class="form-control"
                                required
                            />

                            <label for="cropper_mediaquery_minwidth">
                                Cropped Image Name
                            </label>
                        </div>
                    </div>
                </div> --}}

                <div class="accordions">
                    @foreach(config("centauri")["Cropper"]["items"] as $item)
                        <div class="accordion my-3">
                            <div class="top">
                                {{ $item["label"] }}
                            </div>

                            <div class="bottom" style="display: none;">
                                @foreach($item as $key => $value)
                                    @if(is_array($value))
                                        <div class="row">
                                            @foreach($value as $valItem)
                                                <div class="col-12 col-lg-6">
                                                    <button 
                                                        data-type="{{ $item['DATA_TYPE'] }}"
                                                        data-value="{{ $valItem['value'] }}"
                                                        class="cropper-btn btn btn-primary w-100 waves-effect waves-light"
                                                    >
                                                        {{ $valItem["label"] }}
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row bottom-row">
                    <div class="col-12 col-lg">
                        <button class="btn btn-success waves-effect waves-light" data-type="CROP_IMAGE">
                            <i class="fas fa-crop-alt mr-2"></i>
                            Crop Image
                        </button>
                    </div>

                    <div class="col-12 col-lg">
                        <button class="btn btn-danger waves-effect waves-light" data-type="CROP_CLOSE">
                            <i class="fas fa-times mr-2"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

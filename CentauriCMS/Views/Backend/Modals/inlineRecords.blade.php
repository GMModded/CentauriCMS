@foreach($files as $file)
    @if($file)
        <div class="accordion px-3 ci-bs-1 mb-2" data-uid="{{ $file->uid}}">
            <div class="top py-3">
                {{ $file->name }}
            </div>

            <div class="bottom pb-3" style="display:none;">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="md-form">
                            <input class="form-control" type="text" id="file_title_{{ $file->uid }}" value="{{ $file->title }}" data-uid="{{ $file->uid}}" data-type="{{ $type }}" data-inlinerecord="true" />

                            <label for="file_title_{{ $file->uid }}"{{ ($file->title != "" ? ' class="active"' : '') }}>
                                Title
                            </label>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="md-form">
                            <input class="form-control" type="text" id="file_link_{{ $file->uid }}" value="{{ $file->link }}" data-uid="{{ $file->uid}}" data-type="{{ $type }}" data-inlinerecord="true" />

                            <label for="file_link_{{ $file->uid }}"{{ ($file->link != "" ? ' class="active"' : '') }}>
                                Link
                            </label>
                        </div>
                    </div>
                </div>

                @if($file->cropable)
                    <div class="col-12 col-md-3 image-cropper-view p-0">
                        <img src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($file->uid) !!}" class="img-fluid w-100 d-block ci-bs-1 p-3" />

                        <button class="btn btn-success waves-effect waves-light w-100 mt-2 m-0">
                            Crop Image
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endforeach

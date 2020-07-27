<div id="cropper">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-8 h-100">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <img id="image" class="img-fluid w-100" src="{{ $file->path }}" />
                </div>
            </div>

            <div id="cropper-panel" class="col-4 h-100">
                <div class="row">
                    <div class="col">
                        <div class="img-preview preview-lg"></div>
                        <div class="img-preview preview-md"></div>
                        <div class="img-preview preview-sm"></div>
                        <div class="img-preview preview-xs"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg">
                        <button class="btn btn-primary waves-effect waves-light" data-type="SET_ASPECT_RATIO" data-value="0 / 0">
                            Free
                        </button>
                    </div>

                    <div class="col-12 col-lg">
                        <button class="btn btn-primary waves-effect waves-light" data-type="SET_ASPECT_RATIO" data-value="16 / 9">
                            16 / 9
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg">
                        <button class="btn btn-primary waves-effect waves-light" data-type="SET_ASPECT_RATIO" data-value="5 / 3">
                            5 / 3
                        </button>
                    </div>

                    <div class="col-12 col-lg">
                        <button class="btn btn-success waves-effect waves-light" data-type="CROP_IMAGE">
                            Crop Image
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    #cropper-panel > .row > div {
        padding: 0;
    }

    #cropper-panel > .row > div:not(:last-child) {
        margin-right: 10px;
    }

    #cropper-panel button {
        width: 100%;
    }

    #cropper-panel .row {
        margin: 2.5px 0;
    }

    #cropper-preview {
        width: 100%;
    }

    #cropper {
        position: absolute;
        top: 70px;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: white;
        z-index: 1;
    }

    .img-preview {
        float: left;
        margin-bottom: .5rem;
        margin-right: .5rem;
        overflow: hidden;
    }

    .img-preview > img {
        max-width: 100%;
    }

    .preview-lg {
        height: 9rem;
        width: 16rem;
    }

    .preview-md {
        height: 4.5rem;
        width: 8rem;
        }

    .preview-sm {
        height: 2.25rem;
        width: 4rem;
        }

    .preview-xs {
        height: 1.125rem;
        margin-right: 0;
        width: 2rem;
    }
    </style>

    <script>
        var $image = $("#image");

        $image.cropper({
            aspectRatio: 0,
            preview: ".img-preview",

            crop: (event) => {
                // var canvas = cropper.getCroppedCanvas();
                // canvas.setAttribute("id", "cropper-preview");

                // $("canvas#cropper-preview").replaceWith(canvas);
            }
        });

        // Get the Cropper.js instance after initialized
        var cropper = $image.data("cropper");

        $("#cropper-panel button").each(function() {
            var $this = $(this);

            $this.on("click", this, function() {
                var type = $(this).data("type");

                if(type == "SET_ASPECT_RATIO") {
                    var value = $(this).data("value");
                    value = calcuateRatioAspect(value);
                    cropper.setAspectRatio(value);
                }

                if(type == "CROP_IMAGE") {
                    /** Getter and setter of cropped view of the image. */
                    // var cropBoxData = cropper.getCropBoxData();
                    // cropper.setCropBoxData(cropBoxData);

                    Centauri.Helper.VariablesHelper.__FN_CROP(cropper);
                }
            });
        });

        function calcuateRatioAspect(str) {
            return (str.replace(/\s/g, "").match(/[+\-]?([0-9\.]+)/g) || []).reduce(function(sum, value) {
                return parseFloat(sum) / parseFloat(value);
            });
        }
    </script>
</div>

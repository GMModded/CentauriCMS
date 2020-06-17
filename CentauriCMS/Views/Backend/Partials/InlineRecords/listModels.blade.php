{{-- {{ dd(get_defined_vars()["__data"]) }} --}}

<div class="models p-3" data-namespace="{{ $namespace }}">
    <div class="row mb-3">
        <div class="col align-items-center d-flex">
            <h5 id="headers">
                <span class="d-none d-lg-inline-block">
                    Centauri
                </span>

                » @lang($config["namespace"] . "::backend/modals.models.$namespace")
            </h5>
        </div>

        <div class="col col-md-4">
            <div class="ci-field">
                <input id="filter_modelitems" class="form-control" type="text" />

                <label for="filter_modelitems">
                    Search
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($models as $model)
            @php
                $label = "Item";
                $listLabel = $config["listLabel"] ?? null;

                if(!is_null($listLabel)) {
                    if(Str::contains($listLabel, " ")) {
                        $splittedLabels = explode(" ", $listLabel);
                        $nLabel = $listLabel;

                        foreach($splittedLabels as $splittedLabel) {
                            if(Str::contains($splittedLabel, "{") && Str::contains($splittedLabel, "}")) {
                                $splittedLabel = str_replace("{", "", $splittedLabel);
                                $splittedLabel = str_replace("}", "", $splittedLabel);

                                $splittedLabel = strip_tags($splittedLabel);

                                $nLabel = str_replace("{" . $splittedLabel . "}", $model->$splittedLabel, $nLabel);
                            }
                        }

                        $label = $nLabel;
                    } else {
                        $listLabel = str_replace("{", "", $listLabel);
                        $listLabel = str_replace("}", "", $listLabel);
                    }

                    if(!is_null($model->getAttribute($listLabel))) {
                        $label = $model->getAttribute($listLabel);
                    }
                }
            @endphp

            <div class="col-12 mb-3 py-2">
                <div class="model ci-bs-1 p-3 h-100" data-uid="{{ $model->uid }}">
                    <div class="top">
                        <span class="title mt-2 d-inline-block">
                            {!! $label !!}
                        </span>

                        <div class="button-view float-right">
                            <button class="edit fa-lg btn btn-primary waves-effect btn-floating my-0 mx-1 mt-n2">
                                <i class="fas fa-pen"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

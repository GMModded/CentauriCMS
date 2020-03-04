<div class="models p-3">
    <div class="row mb-3">
        <div class="col align-items-center d-flex">
            <h5 id="headers">
                <span class="d-none d-lg-inline-block">
                    Centauri
                </span>

                » News
            </h5>
        </div>

        <div class="col col-md-4">
            <div class="md-form">
                <input id="filter" class="form-control" type="text" />

                <label for="filter">
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

            <div class="model z-depth-1 col-12 waves-effect py-4 mb-3">
                {!! $label !!}
            </div>
        @endforeach
    </div>
</div>

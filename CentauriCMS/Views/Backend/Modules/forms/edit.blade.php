<div class="p-2">
    <div class="container h-100">
        <div class="row">
            <div class="col-12 pr-0">
                <div class="ci-field">
                    <input class="form-control" type="text" value="{{ $form->name }}" />

                    <label class="active">
                        Name
                    </label>
                </div>
            </div>
        </div>

        <div class="row h-100">
            <div class="col-12 col-lg-8 h-100">
                <div id="ci-forms-currentfields" class="ci-bs-2 h-100 p-3"></div>
            </div>

            <div class="col-12 col-lg-4 p-0">
                <div id="ci-forms-right-panel" class="ci-bs-2 h-100">
                    <div id="ci-forms-tabs">
                        <ul class="list-unstyled m-0">
                            @foreach($data["tabs"] as $tabKey => $tab)
                                <li class="btn btn-default waves-effect waves-light m-0 w-100 py-4{{ (!$loop->first) ? ' mt-1 inactive' : ' active' }}" data-tab="{{ $tabKey }}">
                                    {{ $tab["label"] }}
                                </li>
                            @endforeach
                        </ul>

                        <div id="ci-forms-fields" class="p-3" style="display: block;">
                            <div id="ci-forms-fields-title">
                                {{ $data["tabs"][key($data["tabs"])]["label"] }}
                            </div>

                            <hr class="mb-5">

                            @foreach($data["tabs"] as $tabKey => $tab)
                                @if(isset($tab["fields"]))
                                    <div class="fields{{ $loop->first ? ' active' : '' }}" data-tab="{{ $tabKey }}" data-fields="{{ count($tab['fields']) }}">
                                        @foreach($tab["fields"] as $field)
                                            @php
                                                $type = (isset($field["type"])) ? $field["type"] : "default";

                                                $config = (isset($field["config"]) ? $field["config"] : []);
                                                $jsonConfig = json_encode($config);

                                                $label = (isset($config["label"])) ? $config["label"] : "";

                                                if($label == "" && (isset($config["intern_label"]))) {
                                                    $label = "(Intern Label) " . $config["intern_label"];
                                                }

                                                $placeholder = (isset($config["placeholder"])) ? $config["placeholder"] : "";
                                                $rows = (isset($config["rows"])) ? $config["rows"] : 5;
                                            @endphp

                                            <div 
                                                class="ci-field ci-bs-1 mb-5{{ ($field['HTMLType'] == 'HTML' ? ' is-html' : '') }}"
                                                data-htmltype="{{ $field['HTMLType'] }}"
                                                data-type="{{ $type }}"
                                                data-tab="{{ $tabKey }}"
                                                data-config="{{ $jsonConfig }}"
                                            >
                                                @switch($field["HTMLType"])
                                                    @case("HTML")
                                                        <label class="active">
                                                            {{ $label }}
                                                        </label>

                                                        {!! $field["html"] !!}
                                                        @break

                                                    @case("input")
                                                        @if($type == "default")
                                                            @php $type = "text"; @endphp
                                                        @endif

                                                        <input
                                                            class="form-control mt-2"
                                                            type="{{ $type }}"
                                                            placeholder="{{ $placeholder }}"
                                                            disabled
                                                        />
                                                        @break
                                                    @case("textarea")
                                                        <textarea 
                                                            class="form-control mt-2"
                                                            rows="{{ $rows }}"
                                                            placeholder="{{ $placeholder }}"
                                                            disabled
                                                        ></textarea>
                                                        @break
                                                    @default
                                                        LMFAO GG
                                                @endswitch

                                                @if($label != "" && $field["HTMLType"] != "HTML")
                                                    @if($placeholder != "")
                                                        <label class="active">
                                                    @else
                                                        <label>
                                                    @endif
                                                        {{ $label }}
                                                    </label>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div id="ci-forms-fieldconfig" class="py-2 px-3" style="display: none;">
                        <div class="row row-buttons">
                            <button class="col btn btn-success waves-effect waves-light m-0" data-id="save" data-trigger="SaveEditorComponent">
                                <i class="fas fa-save fa-lg mr-1"></i>

                                Save
                            </button>

                            <button class="col btn btn-warning waves-effect waves-light m-0" data-id="cancel" data-trigger="CloseEditorComponent">
                                <i class="fas fa-times fa-lg mr-1"></i>

                                Cancel
                            </button>

                            <button class="col-12 btn btn-danger waves-effect waves-light m-0" data-id="cancel" data-trigger="CloseEditorComponent">
                                <i class="fas fa-times fa-lg mr-1"></i>

                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Switching tab logic of form fields on the right panel.
 */
$("#ci-forms-tabs ul li").on("click", this, function() {
    let tab = $(this).data("tab");

    $("#ci-forms-tabs ul li.active").removeClass("active");
    $("#ci-forms-tabs ul li.inactive").removeClass("inactive");

    $("#ci-forms-fields .fields:not([data-tab='" + tab + "'])").hide();

    $(this).addClass("active");
    $("#ci-forms-tabs ul li:not(.active)").addClass("inactive");

    $("#ci-forms-fields").show();

    let text = $.trim($(this).text());
    $("#ci-forms-fields-title").text(text);

    $("#ci-forms-fields .fields[data-tab='" + tab + "']").show();
});

/**
 * Sorting / Moving of fields in the entire form.
 */
Centauri.Service.FormFieldsSortingService();
</script>

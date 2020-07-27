@php
    if(is_null($data["gridConfig"]["config"])) {
        $data["gridConfig"]["config"] = [
            0 => [
                "cols" => [
                    0 => [
                        "label" => "backend/be_layout.layouts.default.cols.content"
                    ]
                ]
            ]
        ];
    }
@endphp

@foreach($data["gridConfig"]["config"] as $rowPos => $rowArr)
    <div class="fields">
        @if(isset($data["fieldsBeforeElements"]))
            {!! $data["fieldsBeforeElements"] !!}
        @endif

        <div class="row" data-rowPos="{{ $rowPos }}" style="width: calc(100% + 30px);" data-grid-sorting-rowpos="{{ $rowPos }}">
            @foreach($rowArr["cols"] as $colPos => $colData)
                @if(isset($colData["col"]))
                    <div class="col-12 col-md-{{ $colData['col'] }}" data-colPos="{{ $colPos }}" data-grid-sorting-colpos="{{ $colPos }}">
                @else
                    <div class="col-12 col-md" data-colPos="{{ $colPos }}" data-grid-sorting-colpos="{{ $colPos }}">
                @endif
                        @if(isset($colData["label"]))
                            <h6>
                                @lang($colData["label"])
                            </h6>
                        @endif

                        <div class="sortable-elements">
                            @foreach($data["elements"][$colPos]["elements"] as $element)
                                <button class="new-content-element btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement" data-insert="before" data-type="ingrid" data-gridsparent="{{ $data['gridelement']->uid }}" data-grid-sorting-rowpos="{{ $rowPos }}" data-grid-sorting-colpos="{{ $colPos }}">
                                    <i class="fas fa-plus"></i>
                                    Content
                                </button>

                                <div class="content-element{{ ($element->hidden ? ' hidden' : '') }} ci-bs-1 my-3" data-uid="{{ $element->uid }}" data-sorting="{{ $element->sorting }}">
                                    <div class="top">
                                        <span class="title">
                                            {{ $element->ctype }}
                                        </span>

                                        <div class="button-view float-right">
                                            <button class="edit fa-lg btn btn-primary waves-effect btn-floating m-2">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <button class="new-content-element btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement" data-insert="after" data-type="ingrid" data-gridsparent="{{ $data['gridelement']->uid }}" data-grid-sorting-rowpos="{{ $rowPos }}" data-grid-sorting-colpos="{{ $colPos }}">
                                <i class="fas fa-plus"></i>
                                Content
                            </button>
                        </div>
                    </div>
                @endforeach
        </div>

        @if(isset($data["fieldsAfterElements"]))
            {!! $data["fieldsAfterElements"] !!}
        @endif
    </div>
@endforeach

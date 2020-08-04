<div class="header mb-3 text-center">
    <div class="row">
        <div class="col-12 text-center position-relative">
            <h5 class="mb-n1">
                Editing Page-Content from {{ $data["page"]->title }}
            </h5>

            <small>
                <b>
                    @if($data["page"]->page_type != "storage")
                        » 
                        <a href="{{ $data["page"]->uri }}" target="_blank">
                            {{ $data["page"]->uri }}
                        </a>
                    @else
                        » Storage
                    @endif
                </b>
            </small>

            <div class="right" style="position: absolute; top: -17.5px; right: 15px;">
                <button class="btn btn-primary btn-floating fa-lg edit mx-1 waves-effect" data-action="edit">
                    <i class="fas fa-pen"></i>
                </button>

                <button class="btn btn-info btn-floating fa-lg sort mx-1 waves-effect" data-action="sort">
                    <i class="fas fa-arrows-alt"></i>
                </button>

                <button class="btn btn-danger btn-floating fa-lg delete mx-1 waves-effect"  data-action="delete">
                    <i class="fas fa-trash-alt"></i>
                </button>

                {{-- <script id="elementsbladescript">
                    if(Centauri.Helper.VariablesHelper.__CE_SORTING) {
                        $("#pagecontent .header button.sort i").css("transform", "rotate(135deg)");
                    }

                    $("#elementsbladescript").remove();
                </script> --}}
            </div>
        </div>
    </div>
</div>

<hr>

@foreach($data["beLayout"]["config"] as $rowPos => $rowPosArr)
    <div class="row" data-rowPos="{{ $rowPos }}">
        @foreach($rowPosArr["cols"] as $colPos => $colData)
            @if(isset($colData["col"]))
                <div class="col-12 col-md-{{ $colData['col'] }}" data-colpos="{{ $colPos }}">
            @else
                <div class="col-12 col-md" data-colPos="{{ $colPos }}">
            @endif
                    @if(isset($colData["label"]))
                        <h6>
                            @lang($colData["label"])
                        </h6>
                    @endif

                    <div class="sortable-elements">
                        @foreach($data["elements"] as $element)
                            @if(is_null($element->grids_parent))
                                @if($element->colPos == $colPos)
                                    <button 
                                        class="new-content-element fixed btn btn-default m-0 py-2 px-2 waves-effect waves-light"
                                        data-action="newContentElement"
                                        data-insert="before"
                                    >
                                        <i class="fas fa-plus"></i>

                                        Content
                                    </button>

                                    <div 
                                        class="content-element{{ ($element->hidden ? ' hidden' : '') }} ci-bs-1 my-3"
                                        data-uid="{{ $element->uid }}"
                                        data-sorting="{{ $element->sorting }}"
                                        data-ctype="{{ $element->ctype }}"
                                    >
                                        <div class="top title waves-effect">
                                            <span>
                                                @if(isset($element->customTitle))
                                                    {{ $element->customTitle }}
                                                @else
                                                    {{ $element->ctype }}
                                                @endif
                                            </span>

                                            <div class="button-view float-right">
                                                <button class="edit fa-lg btn btn-primary waves-effect btn-floating m-2">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach

                        <button 
                            class="new-content-element fixed btn btn-default m-0 py-2 px-2 waves-effect waves-light"
                            data-action="newContentElement"
                            data-insert="after"
                        >
                            <i class="fas fa-plus"></i>

                            Content
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

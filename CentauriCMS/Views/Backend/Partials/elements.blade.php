@foreach($data["beLayout"]["config"] as $rowPos => $rowPosArr)
    <div class="row" data-rowPos="{{ $rowPos }}">
        @foreach($rowPosArr["cols"] as $colPos => $colData)
            @if(isset($colData["col"]))
                <div class="col-12 col-md-{{ $colData['col'] }} mb-5 pb-4" data-colpos="{{ $colPos }}">
            @else
                <div class="col-12 col-md mb-5 pb-4" data-colPos="{{ $colPos }}">
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
                                    <button class="fixed btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement" data-insert="before">
                                        <i class="fas fa-plus"></i>
                                        Content
                                    </button>

                                    <div class="content-element z-depth-1 my-3" data-uid="{{ $element->uid }}" data-sorting="{{ $element->sorting }}" data-ctype="{{ $element->ctype }}">
                                        <div class="top">
                                            <span class="title waves-effect">
                                                @if(isset($element->customTitle))
                                                    {{ $element->customTitle }}
                                                @else
                                                    {{ $element->ctype }}
                                                @endif
                                            </span>

                                            <div class="button-view float-right">
                                                <button class="edit btn btn-primary waves-effect waves-light btn-floating m-2">
                                                    <i class="fas fa-pen"></i>
                                                </button>

                                                {{-- <button class="sort btn btn-primary waves-effect waves-light btn-floating my-2 mx-2">
                                                    <i class="fas fa-sort"></i>
                                                </button> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach

                        <button class="fixed btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement" data-insert="after">
                            <i class="fas fa-plus"></i>
                            Content
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

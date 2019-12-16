{{-- {{ dd($data) }} --}}

@foreach($data["beLayout"]["config"] as $rowPos => $colPositions["cols"])
    <div class="row" data-rowPos="{{ $rowPos }}">
        @foreach($colPositions as $colPos => $colData)
            @if(gettype($colData) == "array")
                @if(isset($colData["col"]))
                    <div class="col-12 col-md-{{ $colData['col'] }}">
                @else
                    <div class="col-12 col-md" data-colPos="{{ $colPos }}">
                @endif
            @else
                <div class="col-12 col-md" data-colPos="{{ $colPos }}">
            @endif
                    <h6>
                        @lang($data["beLayout"]["label"])
                    </h6>

                    @foreach($data["elements"] as $element)
                        @if($element->colPos == $colPos)
                            <button class="btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement">
                                <i class="fas fa-plus"></i>
                                Content
                            </button>

                            <div class="content-element z-depth-1 my-3" data-uid="{{ $element->uid }}">
                                <div class="top waves-effect">
                                    <span class="title">
                                        {{ $element->ctype }}
                                    </span>

                                    <i class="fas fa-sort-down"></i>
                                </div>

                                <div class="fields" style="display: none;">
                                    @foreach($data["fields"] as $ctype => $field)
                                        @if(!is_null($element->getAttribute($ctype)))
                                            {!! $field["_HTML"] !!}
                                        @endif
                                    @endforeach

                                    <div class="row">
                                        <div class="col text-right">
                                            <button class="btn btn-success waves-effect waves-light btn-floating" data-id="save" data-trigger="saveSingleElement">
                                                <i class="fas fa-save" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <button class="btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement">
                        <i class="fas fa-plus"></i>
                        Content
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

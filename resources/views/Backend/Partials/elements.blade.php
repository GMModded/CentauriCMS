@foreach($data["beLayout"]["config"] as $rowPos => $rowPosArr)
    <div class="row" data-rowPos="{{ $rowPos }}">
        @foreach($rowPosArr["cols"] as $colPos => $colData)
            @if(isset($colData["col"]))
                <div class="col-12 col-md-{{ $colData['col'] }}">
            @else
                <div class="col-12 col-md" data-colPos="{{ $colPos }}">
            @endif
                    @if(isset($colData["label"]))
                        <h6>
                            @lang($colData["label"])
                        </h6>
                    @endif

                    @foreach($data["elements"] as $element)
                        @if($element->colPos == $colPos)
                            <button class="btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement" data-insert="before">
                                <i class="fas fa-plus"></i>
                                Content
                            </button>

                            {{-- <div class="allowed-pos hidden" style="margin-left:-15px;background:orange;width:calc(100% + 30px);height:100px;z-index:999;"></div> --}}

                            {{-- <div class="current-pos"> --}}
                                <div class="content-element z-depth-1 my-3" data-uid="{{ $element->uid }}" data-sorting="{{ $element->sorting }}">
                                    <div class="top">
                                        <span class="title">
                                            {{ $element->ctype }}
                                        </span>

                                        <button class="edit btn btn-primary waves-effect waves-light float-right btn-floating my-2">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </div>
                                </div>
                            {{-- </div> --}}

                            {{-- <div class="allowed-pos hidden" style="margin-left:-15px;background:orange;width:calc(100% + 30px);height:100px;z-index:999;"></div> --}}
                        @endif
                    @endforeach

                    <button class="btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement" data-insert="after">
                        <i class="fas fa-plus"></i>
                        Content
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

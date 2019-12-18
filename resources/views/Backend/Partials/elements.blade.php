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

                    <div class="sortable-elements">
                        @foreach($data["elements"] as $element)
                            @if($element->colPos == $colPos)
                                <button class="btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement" data-insert="before">
                                    <i class="fas fa-plus"></i>
                                    Content
                                </button>

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
                            @endif
                        @endforeach

                        <button class="btn btn-default m-0 py-2 px-2 waves-effect waves-light" data-action="newContentElement" data-insert="after">
                            <i class="fas fa-plus"></i>
                            Content
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<style>
    .ui-state-highlight { height: 60px; line-height: 1.2em; }

    .ui-state-highlight {
        border: 1px solid #dad55e;
        background: #fffa90!important;
        color: #777620;
    }
</style>

<script>
    function swapNodes(a, b) {
        var aparent = a.parentNode;
        var asibling = a.nextSibling === b ? a : a.nextSibling;
        b.parentNode.insertBefore(a, b);
        aparent.insertBefore(b, asibling);
    }

    $(".content-element").draggable({
        cancel: ".content-element.active",
        revert: true
    }).droppable({
        over: function(event, ui) {
            $(this).addClass("ui-state-highlight");
        },

        out: function(event, ui) {
            $(this).removeClass("ui-state-highlight");
        },

        stop: function(event, ui) {
            $(".content-element.ui-state-highlight").removeClass("ui-state-highlight");
        },

        drop: function(event, ui) {
            $(".content-element.ui-state-highlight").removeClass("ui-state-highlight");
            swapNodes($(this).get(0), $(ui.draggable).get(0));
        }
    });
</script>

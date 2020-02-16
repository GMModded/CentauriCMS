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

                                        <button class="sort btn btn-primary waves-effect waves-light float-right btn-floating my-2">
                                            <i class="fas fa-sort"></i>
                                        </button>

                                        <button class="edit btn btn-primary waves-effect waves-light float-right btn-floating my-2 mr-0">
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
    .element-sort-field { height: 60px; line-height: 1.2em; display: block; cursor: pointer; }

    .element-sort-field:hover {
        background: #fff85d;
    }

    .element-sort-field {
        border: 1px solid #dad55e;
        background: #fffa90;
        color: #777620;
    }

    .content-element {
        position: relative;
    }

    .content-element.sorting {
        z-index: 99999;
    }
</style>

<script>
    var sortingElement = null;

    var mouseDir = "";
    var mouseX = 0;
    var mouseY = 0;

    var a = 0;
    $(".content-element").each(function() {
        $(this).attr("data-index", a);
        a++;
    });

    $(".content-element .sort").each(function() {
        let $sort = $(this);

        $sort.on("click", this, function(e) {
            let $contentelement = $(this).parent().parent();
            $(this).toggleClass("btn-info btn-primary");

            var ceIndex = $contentelement.attr("data-index");

            if($contentelement.hasClass("sorting")) {
                $contentelement.removeClass("sorting");
                $("#editor .bottom .element-sort-field").remove();
                $("#editor .bottom .content-element.__sorting-has-beforeafter-fields").removeClass("__sorting-has-beforeafter-fields");
            } else {
                $contentelement.addClass("sorting");
                sortingElement = $contentelement;

                let index = $contentelement.attr("data-index");
                let i = 0;

                $("#editor .bottom .content-element:not(.__sorting-has-beforeafter-fields)").each(function() {
                    $(this).addClass("__sorting-has-beforeafter-fields");

                    if((ceIndex >= 0 && i >= 1) || ceIndex == 1) {
                        $("<div class='mt-3 element-sort-field before' data-index='" + i + "' data-sorting='" + $(this).data("sorting") + "'></div>").insertBefore($(this));
                        $("<div class='mb-3 element-sort-field after' data-index='" + i + "' data-sorting='" + $(this).data("sorting") + "'></div>").insertAfter($(this));
                    }

                    i++;
                });
 
                $(".sortable-elements").each(function() {
                    if($("> div", $(this)).length == 0) {
                        $(this).append("<div class='my-2 element-sort-field insert' data-index='" + i + "' data-sorting='increment'></div>");
                        i++;
                    }
                });

                $(".element-sort-field").on("click", this, function() {
                    let currentSorting = sortingElement.data("sorting");
                    let currentElementUid = sortingElement.data("uid");
                    let sortto = $(this).data("sorting");

                    let position = "";
                    let targetuid = -1;

                    let data = {
                        rowpos: $(this).parent().parent().parent().data("rowpos"),
                        colpos: $(this).parent().parent().data("colpos"),
                        currentElementUid: currentElementUid,
                        currentSorting: currentSorting,
                        sortto: sortto,
                        targetuid: -1
                    };

                    if($(this).hasClass("before")) {
                        position = "before";
                        targetuid = $(this).prev().data("uid");
                    }
                    if($(this).hasClass("after")) {
                        position = "after";
                        targetuid = $(this).next().data("uid");
                    }
                    if($(this).hasClass("insert")) {
                        position = "insert";
                    }

                    data.direction = position;
                    data.targetuid = targetuid;

                    Centauri.fn.Ajax(
                        "ContentElements",
                        "sortElement",

                        {
                            data: data
                        },

                        {
                            success: (data) => {
                                Centauri.Notify("success", "Moved");
                                Centauri.Helper.findByPidHelper(Centauri.Components.PagesComponent.uid);
                            },

                            error: (data) => {
                                console.error(data);
                            }
                        }
                    );
                });
            }
        });
    });

    // $("#editor .bottom").on("mousemove", this, function(e) {
    //     if(!Centauri.isNull(sortingElement)) {
    //         let top = e.pageY;
    //         let left = e.pageX - $("#editor .bottom").width();

    //         if(Centauri.isUndefined(sortingElement.attr("movingdir"))) {
    //             let pageX = e.pageX;
    //             let pageY = e.pageY;

    //             if(e.pageX > mouseX && e.pageY == mouseY || e.pageX < mouseX && e.pageY == mouseY) {
    //                 mouseDir = "X";
    //             } else if(e.pageX == mouseX && e.pageY > mouseY || e.pageX == mouseX && e.pageY < mouseY) {
    //                 mouseDir = "Y";
    //             }

    //             mouseX = e.pageX;
    //             mouseY = e.pageY;

    //             if(mouseDir != "") {
    //                 sortingElement.attr("movingdir", mouseDir);
    //             }
    //         } else {
    //             mouseDir = sortingElement.attr("movingdir");

    //             if(mouseDir == "X" || mouseDir == "Y") {
    //                 $("#editor .bottom .content-element:not(.__sorting-has-beforeafter-fields)").each(function() {
    //                     $(this).addClass("__sorting-has-beforeafter-fields");
    //                     $("<div class='mt-3 element-sort-field' data-sorting='" + $(this).data("sorting") + "'></div>").insertBefore($(this));
    //                     $("<div class='mb-3 element-sort-field' data-sorting='" + $(this).data("sorting") + "'></div>").insertAfter($(this));
    //                 });

    //                 $(".sortable-elements").each(function() {
    //                     if($("> div", $(this)).length == 0) {
    //                         $(this).append("<div class='my-2 element-sort-field' data-sorting='increment'></div>");
    //                     }
    //                 });

    //                 if(mouseDir == "X" && left >= 70) {
    //                     // sortingElement.css("left", "-70px");
    //                     // sortingElement.css("transform", "translateX(" + left + "px)");
    //                 }

    //                 if(mouseDir == "Y" && top >= 300) {
    //                     // sortingElement.css("top", "-360px");
    //                     // sortingElement.css("transform", "translateY(" + top + "px)");
    //                 }
    //             }
    //         }
    //     }
    // });

    $(document).on("mouseup", this, function(e) {
        if(!Centauri.isNull(sortingElement)) {
            // sortingElement.css("transition", ".3s");
            // sortingElement.css("transform", "unset");

            // sortingElement.removeClass("sorting");
            // sortingElement.removeAttr("movingdir");
            // sortingElement.removeAttr("style");
            // sortingElement = null;

            // $("#editor .bottom .element-sort-field").remove();
            // $("#editor .bottom .content-element.__sorting-has-beforeafter-fields").removeClass("__sorting-has-beforeafter-fields");

            // mouseDir = "";
        }
    });
</script>

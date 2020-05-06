Centauri.Service.CESortingService = () => {
    $(".sortable-elements").each(function() {
        let $this = $(this);
    
        if($(".content-element", $this).length == 0) {
            $this.css({
                minHeight: "60px"
            });
        }
    });

    $(".sortable-elements").sortable({
        connectWith: ".sortable-elements",
        dropOnEmpty: false,
        cancel: ".ck-content",

        start: function(e, ui) {
            $(".sortable-elements button[data-action='newContentElement'").hide();
        },

        stop: function(e, ui) {
            $(".sortable-elements button[data-action='newContentElement'").show();
        },

        update: function(e, ui) {
            let data = [];
            let pid = Centauri.Components.PagesComponent.uid;
            let $this = $(this);

            $(".sortable-elements .content-element").each(function() {
                let $ce = $(this);

                let uid = $ce.data("uid");
                let index = $ce.index();
                let rowPos = $ce.parent().parent().parent().data("rowpos");
                let colPos = $ce.parent().parent().data("colpos");

                let gridsparent = null;
                let grids_sorting_rowpos = null;
                let grids_sorting_colpos = null;

                if($ce.parents(".content-element").data("ctype") == "grids") {
                    gridsparent = $ce.parents(".content-element").data("uid");
                    grids_sorting_rowpos = $ce.parent().parent().parent().data("grid-sorting-rowpos");
                    grids_sorting_colpos = $ce.parent().parent().data("grid-sorting-colpos");
                }

                if(Centauri.isNotNull(uid) && Centauri.isNotNull(index) && Centauri.isNotNull(rowPos) && Centauri.isNotNull(colPos)) {
                    data.push({
                        uid: uid,
                        sorting: index,
                        rowPos: rowPos,
                        colPos: colPos,
                        gridsparent: gridsparent,
                        grids_sorting_rowpos: grids_sorting_rowpos,
                        grids_sorting_colpos: grids_sorting_colpos
                    });
                }
            });

            Centauri.fn.Ajax(
                "ContentElements",
                "sortElement",

                {
                    pid: pid,
                    data: data
                },

                {
                    success: (data) => {
                        data = JSON.parse(data);
                        Centauri.Notify(data.type, data.title, data.description);
                        Centauri.Helper.findByPidHelper(Centauri.Components.PagesComponent.uid);
                    },

                    error: (data) => {
                        $this.sortable("cancel");
                        Centauri.Notify("error", "Element Sorting", "An error occurred while trying to sort this element!");
                    }
                }
            );
        }
    });
};

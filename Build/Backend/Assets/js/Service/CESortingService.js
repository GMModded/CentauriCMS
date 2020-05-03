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

        start: function(e, ui) {
            $(".sortable-elements button[data-action='newContentElement'").remove();
        },

        stop: function(e, ui) {
            let data = [];
            let pid = Centauri.Components.PagesComponent.uid;
            let $this = $(this);

            $(".sortable-elements .content-element").each(function() {
                let $ce = $(this);

                let uid = $ce.data("uid");
                let index = $ce.index();
                let rowPos = $ce.parent().parent().parent().data("rowpos");
                let colPos = $ce.parent().parent().data("colpos");
                let gridsorting = null;

                if($ce.parents(".content-element").data("ctype") == "grids") {
                    gridsorting = $ce.parents(".content-element").data("uid");
                }
    
                if(Centauri.isNotNull(uid) && Centauri.isNotNull(index) && Centauri.isNotNull(rowPos) && Centauri.isNotNull(colPos)) {
                    data.push({
                        uid: uid,
                        sorting: index,
                        rowPos: rowPos,
                        colPos: colPos,
                        gridsorting: gridsorting
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

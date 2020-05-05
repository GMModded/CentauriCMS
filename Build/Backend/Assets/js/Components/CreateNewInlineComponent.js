Centauri.Components.CreateNewInlineComponent = () => {
    $("a.create-new-inline").off("click");

    $("a.create-new-inline").on("click", this, function(e) {
        e.preventDefault();

        let $this = $(this);

        let parentuid = $this.data("parentuid");
        let parentname = $this.parent().data("type-parent");
        let name = $this.data("name");

        Centauri.fn.Ajax(
            "InlineRecords",
            "create",

            {
                parentuid: parentuid,
                parentname: parentname,
                name: name
            },

            {
                success: (data) => {
                    $this.parent().append(data);

                    Centauri.Components.CreateNewInlineComponent();
                    Centauri.Components.AccordionComponent();

                    Centauri.View.ContentElementsView();
                },

                error: (data) => {
                    console.error(data);
                }
            }
        );
    });
};

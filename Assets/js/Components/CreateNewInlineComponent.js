Centauri.Components.CreateNewInlineComponent = () => {
    $("a.create-new-inline").click(function(e) {
        e.preventDefault();

        let name = $(this).data("name");
        let $this = $(this);

        Centauri.fn.Ajax(
            "InlineRecords",
            "create",

            {
                name: name
            },

            {
                success: (data) => {
                    $this.parent().append(data);
                    Centauri.Components.AccordionComponent();
                },

                error: (data) => {
                    console.error(data);
                }
            }
        );
    });
};

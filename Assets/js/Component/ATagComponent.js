Centauri.Component.ATagComponent = () => {
    let _token = $("meta[name='csrf-token']").attr("content");

    $("a").each(function() {
        let $this = $(this);

        $this.on("click", this, function(e) {
            e.preventDefault();
            let href = $(this).attr("href");

            history.pushState(
                {
                    page: 1
                },

                $("title").text(),
                location.href
            );

            $.ajax({
                type: "POST",
                url: href,

                data: {
                    "_token": _token,
                    "dynPageRequest": true
                },

                success: function(data) {
                    $("body section#content").html(data);
                }
            });
        });
    });
};

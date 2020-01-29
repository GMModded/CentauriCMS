Centauri.Init.HeaderInit = () => {
    let $header = $("#header");
    let $blocks = $(".blocks", $header);

    let height = $blocks.height();
    console.log(height);

    $(".tool", $header).each(function() {
        let $tool = $(this);

        $tool.click(() => {
            let type = $(this).data("type");
            let $block = $(".block[data-type='" + type + "']", $blocks);

            if($blocks.hasClass("active")) {
                setTimeout(() => {
                    $block.hide();
                }, 660);
            } else {
                $block.show();
            }

            $blocks.toggleClass("active");
        });
    });
};

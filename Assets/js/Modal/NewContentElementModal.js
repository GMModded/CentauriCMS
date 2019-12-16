Centauri.Modal.NewContentElementModal = function() {
    $("button", $editor).on("click", function() {
        var action = $(this).data("action");

        if(action == "newContentElement") {
            Centauri.fn.Ajax(
                "ContentElements",
                "getConfigCCE",

                {},

                {
                    success: function(data) {
                        Centauri.fn.Modal(
                            "New Content Element",

                            data,

                            {
                                size: "xl",

                                close: {
                                    label: "Clöse"
                                },

                                save: {
                                    label: "Create"
                                }
                            },

                            {
                                save: function() {
                                    var datas = [];

                                    $("#modal .element .bottom .md-form > input").each(function() {
                                        var id = $(this).attr("id");

                                        if(Centauri.isNotUndefined(id)) {
                                            var val = $(this).val();

                                            datas.push(
                                                {
                                                    id: id,
                                                    value: val
                                                }
                                            );
                                        }
                                    });

                                    $(".element .bottom .md-form > div.ck-editor").each(function() {
                                        var id = $(this).parent().find("textarea").attr("id");

                                        if(Centauri.isNotUndefined(id)) {
                                            var val = $(".ck-content", $(this)).html();

                                            datas.push(
                                                {
                                                    id: id,
                                                    value: val
                                                }
                                            );
                                        }
                                    });

                                    Centauri.fn.Ajax(
                                        "ContentElements",
                                        "newElement",

                                        {
                                            ctype: Centauri.Helper.NewContentElementHelper.Element.data("ctype"),
                                            datas: JSON.stringify(datas)
                                        },

                                        {
                                            success: function(data) {
                                                data = JSON.parse(data);
                                                Centauri.Notify(data.type, data.title, data.description);

                                                Centauri.fn.Ajax(
                                                    "ContentElements",
                                                    "findByPid",

                                                    {
                                                        pid: 1
                                                    },

                                                    {
                                                        success: function(data) {
                                                            $container.append(data);

                                                            /**
                                                             * Registering click-event for newCEButton
                                                             */
                                                            Centauri.Modal.NewContentElementModal();

                                                            /**
                                                             * Initializing CKEditor 5
                                                             */
                                                            Centauri.Helper.NewContentElementHelper();

                                                            var $tops = $(".top", $container);
                                                            $tops.each(function() {
                                                                var $top = $(this);

                                                                $top.on("click", function() {
                                                                    $top = $(this);
                                                                    $top.parent().toggleClass("active");

                                                                    if(!$top.hasClass("toggling")) {
                                                                        $top.addClass("toggling");

                                                                        $fields = $top.parent().find(".fields");
                                                                        $fields.slideToggle(function() {
                                                                            $top.removeClass("toggling");
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        }
                                                    }
                                                );
                                            },

                                            error: function(data) {
                                                console.error(data);
                                            }
                                        }
                                    );
                                }
                            }
                        );

                        $("#modal .md-form label").on("click", function(e) {
                            e.preventDefault();
                            $(this).parent().find("input").focus();
                        });

                        /**
                         * Initializing CKEditor 5
                         */
                        Centauri.Helper.NewContentElementHelper();

                        /**
                         * Label focus fix for elements
                         */
                        $(".element").each(function() {
                            $(".top", $(this)).on("click", function() {
                                Centauri.Helper.NewContentElementHelper.Element = $(this).parent();
                                $(this).parent().find(".bottom").slideToggle();
                            });
                        });
                    }
                }
            );
        }
    });
};

Centauri.Helper.NewContentElementHelper.Element = null;

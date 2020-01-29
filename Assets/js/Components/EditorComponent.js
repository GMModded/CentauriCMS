Centauri.Components.EditorComponent = function(type, data) {
    $editor = $("#editor");

    if(type == "show") {
        Centauri.Helper.VariablesHelper.__EditorComponentIsOpen = true;
        Centauri.Components.EditorComponent.FormData = null;
        Centauri.Components.EditorComponent.ButtonsInitialized = false;

        if(Centauri.isNotUndefined(data.size)) {
            $editor.addClass(data.size);
            Centauri.Components.EditorComponent.Size = data.size;
        }

        var crtID   = $editor.attr("data-id");
        var id      = data.id,
            title   = data.title;

        $(".top > p", $editor).html(title);

        if(crtID != id) {
            $editor.attr("data-id", id);

            $("form", $editor).empty();
            $(".bottom > .container", $editor).remove();

            if(Centauri.isNotUndefined(data.form)) {
                Centauri.Components.EditorComponent.FormData = data.form;

                if(Centauri.isNotUndefined(data.callbacks.afterFormInitialized)) {
                    data.callbacks.afterFormInitialized($editor);
                }

                $.each(Centauri.Components.EditorComponent.FormData, function(index, inputObj) {
                    if(Centauri.isNotUndefined(inputObj)) {
                        var type = "text";
                        var placeholder = "";
                        var value = "";
                        var extraAttr = "";
                        var required = "";
                        var label = "";

                        if(Centauri.isNotUndefined(inputObj.type)) {
                            type = inputObj.type;
                        }

                        if(Centauri.isNotUndefined(inputObj.placeholder)) {
                            placeholder = inputObj.placeholder;
                        }

                        if(Centauri.isNotUndefined(inputObj.value)) {
                            value = inputObj.value;
                        }

                        if(Centauri.isNotUndefined(inputObj.extraAttr)) {
                            extraAttr = " " + inputObj.extraAttr;
                        }

                        if(Centauri.isNotUndefined(inputObj.required)) {
                            if(inputObj.required) {
                                required = " required";
                            }
                        }

                        if(Centauri.isNotUndefined(inputObj.label)) {
                            var activeClass = "";

                            if(value.length != 0) {
                                activeClass = " class='active'";
                            }

                            label = "<label for='" + inputObj.id + "'" + activeClass + ">" + inputObj.label + "</label>";
                        }

                        var html = "<div class='md-form'><input class='form-control' type='" + type + "' placeholder='" + placeholder + "' value='" + value + "' id='" + inputObj.id + "'" + extraAttr + required + " />" + label + "</div>";

                        if(type == "custom") {
                            html = Centauri.Utility.EditorUtility.getCustomHTMLByType(inputObj);
                        }

                        $("form", $editor).append(html);
                    }
                });

                $("form .mdb-select", $editor).materialSelect();
                Centauri.Utility.EditorUtility.Validator();
                Centauri.Listener.EditorListener();
            }
        }

        if(Centauri.isNotUndefined(data.container)) {
            Centauri.Components.EditorComponent.Container = data.container;

            if(Centauri.isNotUndefined(data.cols)) {
                $(".bottom", $editor).append("<div class='" + data.container + "'><div class='row'></div></div>");
                $row = $("> .bottom > .container > .row", $editor);

                $.each(data.cols, function(index, colObj) {
                    var col = "col";

                    if(Centauri.isNotUndefined(colObj.size)) {
                        col = "col-" + colObj.size;
                    }

                    $row.append("<div class='" + col + "'>" + colObj.html + "</div>");
                });
            } else if(!$editor.find(".bottom ." + data.container).length) {
                $(".bottom", $editor).append("<div class='" + data.container + "'></div>");
            }
        }

        if(!Centauri.Components.EditorComponent.ButtonsInitialized) {
            Centauri.Components.EditorComponent.ButtonsInitialized = true;

            $("button[data-id='save']", $editor).on("click", function() {
                var formValErr = false;
                var $inputs = $("input.error", $editor);

                $inputs.each(function() {
                    var $input = $(this);

                    if(!$input.parent().hasClass("mdb-select")) {
                        formValErr = true;
                        return;
                    }
                });

                if(Centauri.elExists($("input.error:not(.select-dropdown)", $editor)) || formValErr) {
                    Centauri.Notify("error", "Form Validation", "Please fill out all fields!");
                } else {
                    var formData = [];

                    $("form input", $editor).each(function() {
                        var id = $(this).attr("id");

                        if(Centauri.isNotUndefined(id)) {
                            var value = $(this).val();
                            formData[id] = value;
                        }
                    });

                    $("form select", $editor).each(function() {
                        var id = $(this).attr("id");

                        if(Centauri.isNotUndefined(id)) {
                            var value = $(this).val();
                            formData[id] = value;
                        }
                    });

                    data.callbacks.save(formData);

                    if(Centauri.isNotUndefined(data.loadModuleAfterSaved)) {
                        Centauri.Components.ModulesComponent({
                            type: "load",
                            module: data.loadModuleAfterSaved
                        });
                    }
                }
            });

            $("button[data-id='cancel']", $editor).on("click", function() {
                Centauri.Components.EditorComponent("hide");

                $(".overlayer").addClass("hidden");

                var closer = $(".overlayer").attr("data-closer");
                Centauri.Events.OnOverlayerHiddenEvent(closer);
                Centauri.Events.OnEditorComponentClosedEvent();

                setTimeout(function() {
                    Centauri.Components.EditorComponent("clear", {
                        forceClear: Centauri.Components.EditorComponent.ClearOnClose
                    });
                }, Centauri.Components.EditorComponent.TransitionTime);

                if(Centauri.isNotUndefined(data.callbacks.cancel)) {
                    data.callbacks.cancel();
                }
            });
        }

        if(Centauri.isNotUndefined(data.callbacks.beforeLoaded)) {
            data.callbacks.beforeLoaded($editor);
        }

        $editor.addClass("active");
        setTimeout(function() {
            $(".overlayer").removeClass("hidden");
            $(".overlayer").attr("data-closer", "EditorComponent");

            if(Centauri.isNotUndefined(data.callbacks.loaded)) {
                data.callbacks.loaded($("." + Centauri.Components.EditorComponent.Container, $editor), (crtID == id));
            }
        }, Centauri.Components.EditorComponent.TransitionTime);

        Centauri.Components.EditorComponent.init();
    }

    if(type == "hide") {
        Centauri.Helper.VariablesHelper.__EditorComponentIsOpen = false;
        $editor.removeClass("active");

        setTimeout(function() {
            $(".overlayer").addClass("hidden");
            $(".overlayer").removeAttr("data-closer");
        }, Centauri.Components.EditorComponent.TransitionTime);
    }

    if(type == "clear") {
        if(
            Centauri.Components.EditorComponent.ClearOnClose
        ||
            (Centauri.isNotUndefined(data) && data.forceClear)
        ) {
            $("form", $editor).empty();
            $editor.removeAttr("data-id");
        }

        $editor.removeClass(Centauri.Components.EditorComponent.Size);

        $("button[data-id]", $editor).off();
        Centauri.Components.EditorComponent.ButtonsInitialized = false;
        Centauri.Components.EditorComponent.FormData = null;

        if(Centauri.Components.EditorComponent.Container) {
            Centauri.Components.EditorComponent.Container = "undefined";

            if(Centauri.Components.EditorComponent.ClearOnClose) {
                $(".bottom > .container", $editor).remove();
            }
        }
    }

    if(type == "close") {
        Centauri.Components.EditorComponent("hide");
        Centauri.Components.EditorComponent("clear", {
            forceClear: true
        });
    }

    if(type == "isOpen") {
        return Centauri.Helper.VariablesHelper.__EditorComponentIsOpen;
    }

    if(type == "hasChanged") {
        return Centauri.Helper.VariablesHelper.__EditorComponentHasChanged;
    }
};

Centauri.Components.EditorComponent.init = function() {
    $(".overlayer").on("click", this, function() {
        var closer = $(this).attr("data-closer");

        if(closer == "EditorComponent") {
            setTimeout(function() {
                Centauri.Components.EditorComponent("clear", {
                    forceClear: true
                });
            }, Centauri.Components.EditorComponent.TransitionTime);

            Centauri.Events.OnOverlayerHiddenEvent(closer);
            Centauri.Events.OnEditorComponentClosedEvent();
        }
    });

    $(document).on("keyup", function(e) {
        if(e.which == 27 && !Centauri.elExists($("#modal-new_contentelement"))) {
            var closer = $(".overlayer").attr("data-closer");

            if(closer == "EditorComponent") {
                Centauri.Components.EditorComponent("hide");

                setTimeout(function() {
                    Centauri.Components.EditorComponent("clear", {
                        forceClear: true
                    });
                }, Centauri.Components.EditorComponent.TransitionTime);

                Centauri.Events.OnOverlayerHiddenEvent(closer);
                Centauri.Events.OnEditorComponentClosedEvent();
            }
        }
    });
};

// Component data
Centauri.Components.EditorComponent.TransitionTime = 660;
Centauri.Components.EditorComponent.Size = null;
Centauri.Components.EditorComponent.Container = "undefined";
Centauri.Components.EditorComponent.ButtonsInitialized = false;
Centauri.Components.EditorComponent.ClearOnClose = true;
Centauri.Components.EditorComponent.FormData = null;

// Variables declared for and as helper
Centauri.Helper.VariablesHelper.__EditorComponentIsOpen = false;
Centauri.Helper.VariablesHelper.__EditorComponentHasChanged = false;

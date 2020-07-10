CentauriJS.Utilities.Form.Colorpicker = (additionalConfig = {}) => {
    let el = ".pickr";

    let config = {
        // Selector or element which will be replaced with the actual color-picker.
        // Can be a HTMLElement.
        el: el,

        // Precision of output string (only effective if components.interaction.input is true)
        outputPrecision: 1,

        // Default color. If you're using a named color such as red, white ... set
        // a value for defaultRepresentation too as there is no button for named-colors.
        default: "#000",

        // Default color representation of the input/output textbox.
        // Valid options are `HEX`, `RGBA`, `HSVA`, `HSLA` and `CMYK`.
        defaultRepresentation: "RGBA",

        // Enables the ability to change numbers in an input field with the scroll-wheel.
        // To use it set the cursor on a position where a number is and scroll, use ctrl to make steps of five
        adjustableNumbers: true,

        // Show or hide specific components.
        // By default only the palette (and the save button) is visible.
        components: {

            // Defines if the palette itself should be visible.
            // Will be overwritten with true if preview, opacity or hue are true
            palette: true,

            preview: true, // Display comparison between previous state and new color
            opacity: true, // Display opacity slider
            hue: true,     // Display hue slider

            // show or hide components on the bottom interaction bar.
            interaction: {

                // Buttons, if you disable one but use the format in default: or setColor() - set the representation-type too!
                hex: true,  // Display 'input/output format as hex' button  (hexadecimal representation of the rgba value)
                rgba: true, // Display 'input/output format as rgba' button (red green blue and alpha)
                hsla: true, // Display 'input/output format as hsla' button (hue saturation lightness and alpha)
                hsva: true, // Display 'input/output format as hsva' button (hue saturation value and alpha)
                cmyk: true, // Display 'input/output format as cmyk' button (cyan mangenta yellow key )

                input: true, // Display input/output textbox which shows the selected color value.
                                // the format of the input is determined by defaultRepresentation,
                                // and can be changed by the user with the buttons set by hex, rgba, hsla, etc (above).
                cancel: true, // Display Cancel Button, resets the color to the previous state
                clear: true, // Display Clear Button; same as cancel, but keeps the window open
                save: true,  // Display Save Button,
            },
        },

        // Translations, these are the default values.
        i18n: {

            // Strings visible in the UI
            "ui:dialog": "color picker dialog",
            "btn:toggle": "toggle color picker dialog",
            "btn:swatch": "color swatch",
            "btn:last-color": "use previous color",
            "btn:save": "Save",
            "btn:cancel": "Cancel",
            "btn:clear": "Clear",

            // Strings used for aria-labels
            "aria:btn:save": "save and close",
            "aria:btn:cancel": "cancel and close",
            "aria:btn:clear": "clear and close",
            "aria:input": "color input field",
            "aria:palette": "color selection area",
            "aria:hue": "hue selection slider",
            "aria:opacity": "selection slider"
        }
    };

    if(JSON.stringify(additionalConfig) != "{}") {
        config = additionalConfig;
    }

    if(Centauri.elExists(config.el)) {
        const pickr = new Pickr(config);

        pickr.on("save", (color, instance) => {
            let $input = $(instance._root.root).next("input");
            $input.val(color.toRGBA().toString());
            $("+ label", $input).focus();
        });

        return pickr;
    }

    return null;
};

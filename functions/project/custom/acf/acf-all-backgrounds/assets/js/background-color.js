/**
 * Included when FIELD_NAME fields are rendered for editing by publishers.
 */
(function ($) {
    function getColorName(className) {
        if (className) {
            switch (className) {
                case "f--background-a":
                    return "White";
                case "f--background-b":
                    return "Grey";
                case "f--background-c":
                    return "Purple";
                case "f--background-d":
                    return "Dark Purple";
                default:
                    return "Select a background color";
            }
        }
    }
    function initialize_field($field) {

        $.each($($field.find(".js--background-color-all")), function () {
            var selector = $(this).find(".options ul");
            var selectorSpan = $(this).find(".selected a span");

            $(this)
                .find(".selected a")
                .click(function () {
                    selector.toggle();
                });
            //SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
            $(this)
                .find("ul li a")
                .click(function () {
                    $field.find("input").val($(this).attr("data-value"));
                    selectorSpan.html(`<div class="${$(this).attr("data-value")}">` + getColorName($field.find("input").val()) + "</div>");
                    selector.hide();
                });
            if ($field.find("input").val()) {
                selectorSpan.html(`<div class="${$field.find("input").val()}">` + getColorName($field.find("input").val()) + "</div>");
            } else {
                $(this).find(".selected a").val("-");
            }
        });
    }

    if (typeof acf.add_action !== "undefined") {
        /**
         * Run initialize_field when existing fields of this type load,
         * or when new fields are appended via repeaters or similar.
         */
        acf.add_action("ready_field/type=allbackgroundcolor", initialize_field);
        acf.add_action("append_field/type=allbackgroundcolor", initialize_field);
    }
})(jQuery);

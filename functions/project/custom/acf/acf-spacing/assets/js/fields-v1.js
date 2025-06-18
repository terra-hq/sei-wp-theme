/**
 * Included when FIELD_NAME fields are rendered for editing by publishers.
 */
const spacingOptions = {
  "bottom-small": {
    value: "j",
    css: "u--pb-7 u--pb-tablets-4",
  },
  "bottom-medium": {
    value: "i",
    css: "u--pb-10 u--pb-tablets-7",
  },
  "bottom-large": {
    value: "h",
    css: "u--pb-15 u--pb-tablets-10",
  },
  "bottom-extra-large": {
    value: "b-xl",
    css: "u--pb-22 u--pb-tablets-15",
  },
  "top-small": {
    value: "g",
    css: "u--pt-7 u--pt-tablets-4",
  },
  "top-medium": {
    value: "f",
    css: "u--pt-10 u--pt-tablets-7",
  },
  "top-large": {
    value: "e",
    css: "u--pt-15 u--pt-tablets-10",
  },
  "top-extra-large": {
    value: "t-xl",
    css: "u--pt-22 u--pt-tablets-15",
  },
  // MIXED OPTIONS
  "top-small-bottom-small": {
    value: "g j",
    css: "u--pt-7 u--pt-tablets-4 u--pb-7 u--pb-tablets-4",
  },
  "top-small-bottom-medium": {
    value: "g i",
    css: "u--pt-7 u--pt-tablets-4 u--pb-10 u--pb-tablets-7",
  },
  "top-small-bottom-large": {
    value: "g h",
    css: "u--pt-7 u--pt-tablets-4 u--pb-15 u--pb-tablets-10",
  },
  "top-small-bottom-extra-large": {
    value: "g t-xl",
    css: "u--pt-7 u--pt-tablets-4 u--pb-22 u--pb-tablets-15",
  },
  "top-medium-bottom-small": {
    value: "f j",
    css: "u--pt-10 u--pt-tablets-7 u--pb-7 u--pb-tablets-4",
  },
  "top-medium-bottom-medium": {
    value: "f i",
    css: "u--pt-10 u--pt-tablets-7 u--pb-10 u--pb-tablets-7",
  },
  "top-medium-bottom-large": {
    value: "f h",
    css: "u--pt-10 u--pt-tablets-7 u--pb-15 u--pb-tablets-10",
  },
  "top-medium-bottom-extra-large": {
    value: "f t-xl",
    css: "u--pt-10 u--pt-tablets-7 u--pb-22 u--pb-tablets-15",
  },
  "top-large-bottom-small": {
    value: "e j",
    css: "u--pt-15 u--pt-tablets-10 u--pb-7 u--pb-tablets-4",
  },
  "top-large-bottom-medium": {
    value: "e i",
    css: "u--pt-15 u--pt-tablets-10 u--pb-10 u--pb-tablets-7",
  },
  "top-large-bottom-large": {
    value: "e h",
    css: "u--pt-15 u--pt-tablets-10 u--pb-15 u--pb-tablets-10",
  },
  "top-large-bottom-extra-large": {
    value: "e t-xl",
    css: "u--pt-15 u--pt-tablets-10 u--pb-22 u--pb-tablets-15",
  },
  "top-extra-large-bottom-small": {
    value: "t-xl j",
    css: "u--pt-15 u--pt-tablets-10 u--pb-7 u--pb-tablets-4",
  },
  "top-extra-large-bottom-medium": {
    value: "t-xl i",
    css: "u--pt-15 u--pt-tablets-10 u--pb-10 u--pb-tablets-7",
  },
  "top-extra-large-bottom-large": {
    value: "t-xl h",
    css: "u--pt-15 u--pt-tablets-10 u--pb-15 u--pb-tablets-10",
  },
  "top-extra-large-bottom-extra-large": {
    value: "t-xl b-xl",
    css: "u--pt-15 u--pt-tablets-10 u--pb-22 u--pb-tablets-15",
  },
};

function findKeyByValue(dictionary, value = null, css = null) {
  if (value) return Object.keys(dictionary).find((key) => dictionary[key].css === value);
  else if (css) return Object.keys(dictionary).find((key) => dictionary[key].css === css);
  else return;
}

(function ($) {
  function setActiveState($field, selector, activeVal) {
    $.each($($field.find(selector).find("button")), function () {
      $(this)
        .toggleClass("active", $(this).val() === activeVal)
        .toggleClass("no-active", $(this).val() !== activeVal);
    });
  }

  function setInputValue($field, topKey, bottomKey) {
    let res = "";

    if (topKey && bottomKey) {
      res = `${topKey} ${bottomKey}`;
    } else if (topKey) {
      res = topKey;
    } else if (bottomKey) {
      res = bottomKey;
    }

    console.log("CUSTOM SPACING - SAVING; ", res);
    $field.find("input").val(res ? res : "-");
  }

  function initialize_field($field) {
    /**
     * $field is a jQuery object wrapping field elements in the editor.
     */
    var top = "";
    var bottom = "";

    var topSpace = $field.find(".js--top-space");
    var bottomSpace = $field.find(".js--bottom-space");
    var topTitle = $field.find(".js--top-title");
    var bottomTitle = $field.find(".js--bottom-title");
    const foundKey = $field.find("input").val().replace(/\s+/g, "-");
    const spacing = spacingOptions[foundKey];

    console.log("CUSTOM SPACING - SAVED; ", $field.find("input").val());

    var topOption = null;
    var bottomOption = null;

    if (foundKey.includes("-bottom-")) {
      const [_topOption, _bottomOption] = foundKey.split("-bottom-");
      topOption = _topOption;
      bottomOption = `bottom-${_bottomOption}`;
    } else if (foundKey.includes("bottom-")) {
      bottomOption = foundKey;
    } else {
      topOption = foundKey;
    }

    if (spacing) {
      // SET SPACING OPTIONS
      top = spacingOptions[topOption]?.css || "";
      bottom = spacingOptions[bottomOption]?.css || "";
      setActiveState($field, ".js--top-space", spacing.value);
      setActiveState($field, ".js--bottom-space", spacing.value);
    }

    $.each($($field.find(".js--padding").find("button")), function () {
      // MAP SPACING OPTIONS
      const currentVal = $(this).val();

      if (foundKey && foundKey.includes("bottom") && foundKey.includes("top")) {
        if (currentVal === "a") $(this).addClass("active").removeClass("no-active");
        else $(this).addClass("no-active").removeClass("active");
      } else if (foundKey && foundKey.includes("bottom")) {
        if (currentVal === "b") $(this).addClass("active").removeClass("no-active");
        else $(this).addClass("no-active").removeClass("active");
      } else if (foundKey && foundKey.includes("top")) {
        if (currentVal === "d") $(this).addClass("active").removeClass("no-active");
        else $(this).addClass("no-active").removeClass("active");
      } else {
        $(this).addClass("no-active").removeClass("active");
      }

      $(this).on("click", (e) => {
        // ON SECTION SPACING OPTION CLICK
        e.preventDefault();
        $.each($($field.find(".js--padding").find("button")), function () {
          $(this).addClass("no-active");
        });
        $(this).addClass("active").removeClass("no-active");
        top = bottom = "";

        switch (currentVal) {
          case "a":
            topSpace.css("display", "inline-flex");
            bottomSpace.css("display", "inline-flex");
            topTitle.show();
            bottomTitle.show();
            top = spacingOptions["top-extra-large"].css;
            bottom = spacingOptions["bottom-extra-large"].css;
            setActiveState($field, ".js--top-space", spacingOptions["top-extra-large"].value);
            setActiveState($field, ".js--bottom-space", spacingOptions["bottom-extra-large"].value);
            break;
          case "d":
            topSpace.css("display", "inline-flex");
            bottomSpace.hide();
            topTitle.show();
            bottomTitle.hide();
            top = spacingOptions["top-extra-large"].css;
            setActiveState($field, ".js--top-space", spacingOptions["top-extra-large"].value);
            break;
          case "b":
            topSpace.hide();
            bottomSpace.css("display", "inline-flex");
            topTitle.hide();
            bottomTitle.show();
            bottom = spacingOptions["bottom-extra-large"].css;
            setActiveState($field, ".js--bottom-space", spacingOptions["bottom-extra-large"].value);
            break;
          default:
            topSpace.hide();
            bottomSpace.hide();
            topTitle.hide();
            bottomTitle.hide();
            break;
        }
        setInputValue($field, findKeyByValue(spacingOptions, null, top), findKeyByValue(spacingOptions, null, bottom));
      });
    });

    $.each($($field.find(".js--top-space").find("button")), function () {
      // MAP TOP OPTIONS
      const current = $(this).val();
      if (topOption && spacingOptions[topOption] && spacingOptions[topOption].value.includes(current)) {
        $(this).addClass("active").removeClass("no-active");
        topSpace.css("display", "inline-flex");
        topTitle.show();
      } else {
        $(this).addClass("no-active").removeClass("active");
      }

      $(this).on("click", (e) => {
        // SET TOP OPTION
        e.preventDefault();
        const buttonValue = $(this).val();

        const topKey = Object.keys(spacingOptions).find((key) => spacingOptions[key].value === buttonValue);
        const bottomKey = findKeyByValue(spacingOptions, bottom);
        top = spacingOptions[topKey].css;
        setInputValue($field, topKey, bottomKey);

        $field.find(".js--top-space button").each(function () {
          $(this)
            .toggleClass("active", $(this).val() === buttonValue)
            .toggleClass("no-active", $(this).val() !== buttonValue);
        });
      });
    });

    $.each($($field.find(".js--bottom-space").find("button")), function () {
      // MAP BOTTOM OPTIONS
      const current = $(this).val();

      if (bottomOption && spacingOptions[bottomOption] && spacingOptions[bottomOption].value.includes(current)) {
        $(this).addClass("active").removeClass("no-active");
        bottomSpace.css("display", "inline-flex");
        bottomTitle.show();
      } else {
        $(this).addClass("no-active").removeClass("active");
      }

      $(this).on("click", (e) => {
        // SET BOTTOM OPTION
        e.preventDefault();
        const buttonValue = $(this).val();

        const topKey = findKeyByValue(spacingOptions, top);
        const bottomKey = Object.keys(spacingOptions).find((key) => spacingOptions[key].value === buttonValue);
        bottom = spacingOptions[bottomKey].css;
        setInputValue($field, topKey, bottomKey);

        $field.find(".js--bottom-space button").each(function () {
          $(this)
            .toggleClass("active", $(this).val() === buttonValue)
            .toggleClass("no-active", $(this).val() !== buttonValue);
        });
      });
    });
  }

  if (typeof acf.add_action !== "undefined") {
    /**
     * Run initialize_field when existing fields of this type load,
     * or when new fields are appended via repeaters or similar.
     */

    acf.add_action("ready_field/type=spacing", initialize_field);
    acf.add_action("append_field/type=spacing", initialize_field);
  }
})(jQuery);

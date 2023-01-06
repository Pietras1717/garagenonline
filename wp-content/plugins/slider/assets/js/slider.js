jQuery(document).ready(function () {
  //info messege closebtn
  jQuery(".closebtn").on("click", function () {
    jQuery(this).parent().css({
      visibility: "hidden",
      opacity: 0,
    });
  });

  //   Shortcode copy to clipboard
  jQuery("#copyShortcodeClipboard").on("click", function () {
    // Copy to cliboard
    let value = jQuery(this).siblings()[0].value;
    let $temp = jQuery("<input>");
    jQuery("body").append($temp);
    $temp.val(value).select();
    document.execCommand("copy");
    $temp.remove();

    // Show confirmation allert
    showMessageAlert("info", "Shortcode został skopiowany do schowka");
  });

  // Send options settings with ajax
  jQuery("#frmSettings").submit(function () {
    const inputs = [...jQuery(this).find("input, select")];
    let postData = {
      action: "slider",
      requestParam: "save-settings",
    };
    inputs.forEach((input) => {
      let name = input["name"];
      let type = input["type"];
      let value;
      if (type === "checkbox") {
        let checked = jQuery(input).is(":checked");
        value = checked;
      } else {
        value = input["value"];
      }
      postData[name] = value;
    });

    jQuery.ajax({
      url: ajax,
      data: postData,
      success: function () {
        // Show confirmation allert
        showMessageAlert("success", "Ustawienia pomyślnie zaktualizowane");
      },
      error: function () {
        // Show confirmation allert
        showMessageAlert("error", "Wystąpił błąd podczas zapisywania");
      },
    });
  });
});

function showMessageAlert(className = "info", html = "") {
  jQuery(".info-message")
    .css({
      visibility: "visible",
      opacity: 1,
    })
    .attr("class", ".info-message")
    .addClass(className)
    .find("p")
    .html("<strong>" + className + "!</strong> " + html);

  //   Hide confirmation alert after 3 seconds
  setTimeout(() => {
    jQuery(".info-message")
      .css({
        visibility: "hidden",
        opacity: 0,
      })
      .removeClass(className)
      .find("p")
      .html("");
  }, 5000);
}

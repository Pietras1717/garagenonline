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
});

function showMessageAlert(className = "info", html = "") {
  jQuery(".info-message")
    .css({
      visibility: "visible",
      opacity: 1,
    })
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

jQuery(document).ready(function () {
  //info messege closebtn
  jQuery(".closebtn").on("click", function () {
    jQuery(this).parent().css({
      visibility: "hidden",
      opacity: 0,
    });
    location.reload();
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

  // Form sending
  jQuery("#frmGoogleReviews").submit(function () {
    const inputs = [...jQuery(this).find('input[name="GoogleReviewCid"]')][0];
    let postData = {
      action: "google_reviews",
      requestParam: "save-cid",
      google_reviews_cid: inputs["value"],
    };
    jQuery.ajax({
      url: ajax,
      data: postData,
      success: function (data) {
        showMessageAlert("success", "CID pomyślnie zapisany");
      },
      error: function () {
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
    .attr("class", "info-message")
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
    location.reload();
  }, 5000);
}

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

  //   Adding dataTable support

  jQuery("#sliderList").DataTable();

  //   Add upload image

  jQuery("#sliderUploadImage").on("click", function (e) {
    e.preventDefault();
    let image = wp
      .media({
        title: "Wybierz zdjęcie dle nowego slajdu",
        multiple: false,
      })
      .open()
      .on("select", function () {
        let uploadedImage = image.state().get("selection").first();
        let getImage = uploadedImage.toJSON().url;
        jQuery(".imgSection > img").attr({
          src: getImage,
          "data-img": getImage,
        });
      });
  });

  //   Send new slide data with ajax

  jQuery("#frmNewSlide").submit(function () {
    const heading = jQuery('input[id="heading"]').val();
    const content = jQuery('textarea[id="content"]').val();
    const imgSrc = jQuery(".imgSection > img").attr("data-img");
    let validationResult = formValidation(heading, content, imgSrc);
    console.log(validationResult);
    if (validationResult) {
      // pokazanie errorów
      jQuery(".error.heading").text(validationResult.heading);
      jQuery(".error.content").text(validationResult.content);
      jQuery(".error.image").text(validationResult.imgSrc);
    } else {
      // czyszczenie errorów
      jQuery(".error.heading").text("");
      jQuery(".error.content").text("");
      jQuery(".error.image").text("");

      //   obsługa ajax
      jQuery.ajax({
        url: ajax,
        data: {
          action: "slider",
          requestParam: "add-new-slide",
          heading: heading,
          content: content,
          imgSrc: imgSrc,
        },
        success: function () {
          // Show confirmation allert
          showMessageAlert("success", "Nowy slajd został pomyślnie dodany");
        },
        error: function () {
          // Show confirmation allert
          showMessageAlert(
            "error",
            "Wystąpił błąd podczas dodawnia nowego slajdu. Spróbuj ponownie!"
          );
        },
      });
    }
  });

  //   Delete slide with ajax
  jQuery("#deleteSlide").on("click", function () {
    let id = jQuery(this).attr("data-id");
    //   obsługa ajax
    jQuery.ajax({
      url: ajax,
      data: {
        action: "slider",
        requestParam: "delete-slide",
        id: id,
      },
      success: function () {
        // Show confirmation allert
        showMessageAlert(
          "success",
          "Slajd #" + id + " został pomyślnie usunięty!"
        );
      },
      error: function () {
        // Show confirmation allert
        showMessageAlert(
          "error",
          "Wystąpił błąd podczas usuwania slajdu. Spróbuj ponownie!"
        );
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

function formValidation(heading, content, imgSrc) {
  let messages = {
    heading: "",
    content: "",
    imgSrc: "",
  };
  let error = false;
  if (heading.length <= 3) {
    messages.heading = "Nagłówek slajdu musi mieć min 3 znaki";
    error = true;
  }
  if (content.length <= 10) {
    messages.content = "Content slajdu musi mieć min 10 znaków";
    error = true;
  }
  if (imgSrc == "") {
    messages.imgSrc = "Obrazek musi być dodany";
    error = true;
  }

  if (error) return messages;
  return error;
}

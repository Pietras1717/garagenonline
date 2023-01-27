// account menu open dropdown
const accountMenu = document.querySelector(
  "#account-menu > ul > li.menu-item-has-children > a"
);
accountMenu.addEventListener("click", function () {
  this.nextElementSibling.classList.toggle("active");
});

// add sticky to menu wheen scroll
const stickyBlock = document.querySelector(
  "div.navbar-wrapper > div.logo-wrapper"
);
const navbar = document.querySelector(".navbar");
const wooCommerceMenu = document.querySelector(".woocommerce-menu");
document.addEventListener("scroll", function () {
  let scroll = window.scrollY;
  if (scroll > 200) {
    stickyBlock.classList.add("active");
    navbar.classList.add("active");
    wooCommerceMenu.classList.add("disabled");
  } else {
    stickyBlock.classList.remove("active");
    navbar.classList.remove("active");
    wooCommerceMenu.classList.remove("disabled");
  }
});

// obsługa hamburgera

const burgers = [...document.querySelectorAll(".burger, .close-menu-btn")];
const mainMenu = document.querySelector(".main-menu");
burgers.forEach((item) => {
  item.addEventListener("click", function () {
    mainMenu.classList.toggle("active");
    burgers.forEach((item) => {
      item.classList.toggle("active");
      let icon = item.querySelector("i");
      icon.getAttribute("class").indexOf("bars") > -1
        ? icon.setAttribute("class", "fa fa-times")
        : icon.setAttribute("class", "fa fa-bars");
    });
  });
});

// Dropdown Menu Active
jQuery("#menu-menu-glowne > li.menu-item-has-children").on(
  "click",
  function () {
    jQuery(this).toggleClass("active");
    let klasa = jQuery(this).find("a i").attr("class");
    let icons = jQuery(this).find("a i");
    klasa.indexOf("down") > -1
      ? icons.attr("class", "fa fa-caret-up")
      : icons.attr("class", "fa fa-caret-down");
    jQuery(this).find("ul.sub-menu").toggleClass("active");
  }
);
jQuery(document).click(function (t) {
  if (
    0 != jQuery(t.target).closest("li.menu-item-has-children.active").length
  ) {
    return !1;
    $("ul.sub-menu.active").removeClass("active");
  }
});

// mini cart showing

const miniCart = document.querySelector(".mini-cart");
const triggerButton = document.querySelector("#show-mini-cart");
triggerButton.addEventListener("click", function () {
  miniCart.classList.toggle("is-showing");
});

// load more button referenzen
jQuery(".single-referenze").slice(0, 4).show();
jQuery("#loadMore").on("click", function (e) {
  e.preventDefault();
  jQuery(".single-referenze:hidden").slice(0, 4).slideDown();
  if (jQuery(".single-referenze:hidden").length == 0) {
    jQuery("#loadMore").text("No more Content").addClass("noContent");
  }
});

// multi steps acfpro
jQuery(function ($) {
  var steps = jQuery(".wapf-section.step");
  if (!steps.length) return;
  var maxSteps = steps.length;
  var $prev = jQuery(".wapf_btn_prev");
  var $next = jQuery(".wapf_btn_next");
  var $stepList = jQuery(".wapf-progress-steps");
  var $bar = jQuery(".wapf-progress-bar");
  var $cart = jQuery('div.quantity,[name="add-to-cart"]');
  var $progress = jQuery(".wapf-progress");
  var currentStep = 1;
  $cart.hide();

  for (var i = 1; i <= maxSteps; i++) {
    var $div = jQuery("<div>");
    if (i === 1) $div.addClass("active");
    $stepList.append($div);
  }

  var post = function (e) {
    var visibleStepLi = $stepList.find("div:visible");
    var idx = $stepList.find("div").index(visibleStepLi.eq(currentStep - 1));
    idx = Math.max(0, idx);
    var max = visibleStepLi.length;
    if (e) e.preventDefault();
    steps.hide().removeClass("stepActive");
    steps.eq(idx).css("display", "flex").addClass("stepActive");

    $stepList
      .find("div")
      .removeClass("active")
      .eq(idx)
      .addClass("active")
      .prevAll()
      .addClass("active");
    if (currentStep >= max) {
      $cart.show();
    } else $cart.hide();

    $bar.css("width", (currentStep - 1) * (100 / (max - 1)) + "%");

    $prev.hide();
    $next.hide();
    if (currentStep < max) $next.show();
    if (currentStep > 1) $prev.show();
    jQuery(document).trigger("wapf_step", [currentStep, max]);
  };

  var isValid = function () {
    var $inputs = steps.filter(".stepActive").find(":input");

    for (var i = 0; i < $inputs.length; i++) {
      if (!$inputs[i].checkValidity()) return false;
    }
    return true;
  };

  $prev.on("click", function (e) {
    currentStep--;
    post(e);
  });

  $next.on("click", function (e) {
    var valid = isValid();
    if (isValid()) {
      currentStep++;
      post(e);
    }
  });

  jQuery(document).on("wapf/dependencies", function () {
    $stepList.find("div").removeClass("wapf-hide");
    steps.each(function (i, s) {
      var $s = jQuery(s);
      if ($s.hasClass("wapf-hide"))
        $stepList.find("div:eq(" + i + ")").addClass("wapf-hide");
    });
    if ($stepList.find("div:not(.wapf-hide)").length <= 1) $progress.hide();
    else $progress.show();

    post();
  });

  // Block enter key to prevent jumping to another step on accident.
  steps.find("input, select").keypress(function (event) {
    return event.key != "Enter";
  });
});

// add img full screen function

jQuery(".wapf-field-input > img, .woocommerce-tabs  img").on(
  "click",
  function () {
    const src = jQuery(this).attr("src").replace("-300x225", "");
    window.open(src, "_blank");
  }
);

// scroll to top of section

// jQuery(".wapf_btn_prev, .wapf_btn_next").on("click", function (e) {
//   const firstElement = document
//     .querySelector("div.wapf-section.field-63c0720c34f64.step")
//     .classList.contains("stepActive");
//   if (!firstElement) {
//     jQuery("html").animate(
//       {
//         scrollTop: jQuery(".product_title").offset().top,
//       },
//       500 //speed
//     );
//   }
// });

// change step in inputs

jQuery(
  '[data-field-id="63c07268ec22a"], [data-field-id="63c072fea4fdf"], [data-field-id="63c1dca3b6284"], [data-field-id="63c1dca3b62e9"], [data-field-id="63c1ed80d8e04"], [data-field-id="63c1ed80d8e70"], [data-field-id="63c2692742883"], [data-field-id="63c26927428be"], [data-field-id="63c26e99e5568"], [data-field-id="63c26e99e557d"], [data-field-id="63c1e6a2dd739"], [data-field-id="63c1e6a2dd75d"], [data-field-id="63c1cb33652bf"], [data-field-id="63c1cb33652ec"]'
).attr("step", "0.01");

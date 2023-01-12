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
  var steps = $(".wapf-section.step");
  if (!steps.length) return;
  var maxSteps = steps.length;
  var $prev = $(".wapf_btn_prev");
  var $next = $(".wapf_btn_next");
  var $stepList = $(".wapf-progress-steps");
  var $bar = $(".wapf-progress-bar");
  var $cart = $('div.quantity,[name="add-to-cart"]');
  var $progress = $(".wapf-progress");
  var currentStep = 1;

  for (var i = 1; i <= maxSteps; i++) {
    var $div = $("<div>");
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
    $(document).trigger("wapf_step", [currentStep, max]);
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

  $(document).on("wapf/dependencies", function () {
    $stepList.find("div").removeClass("wapf-hide");
    steps.each(function (i, s) {
      var $s = $(s);
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

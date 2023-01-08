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

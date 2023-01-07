// Elements
const slides = [...document.querySelectorAll(".slides .single-slide")];
const dots = [...document.querySelectorAll(".dots .single-dot")];
const slider = [...document.querySelectorAll(".slider")];

// Settings
const time = slider[0].getAttribute("data-time");
let active = 0;

// Interpretation

const updateClassActive = (...elements) => {
  elements.forEach((element, index) => {
    if (typeof element === "object") {
      element.forEach((item) => {
        item.classList.remove("active");
      });
      elements[index][active].classList.add("active");
    }
  });
};

const changeSlide = () => {
  active++;
  if (active === slides.length) {
    active = 0;
  }
  updateClassActive(slides, dots);
};

let currentInterval = setInterval(() => {
  changeSlide();
}, time);

dots.forEach((dot, index) => {
  dot.addEventListener("click", function () {
    clearInterval(currentInterval);
    active = index;
    updateClassActive(slides, dots);
    currentInterval = setInterval(() => {
      changeSlide();
    }, time);
  });
});

window.addEventListener("keydown", function () {
  if (this.event.keyCode === 37 || this.event.keyCode === 39) {
    if (this.event.keyCode === 37) {
      clearInterval(currentInterval);
      if (active === slides.length) {
        active = 0;
      } else if (active === 0) {
        active = slides.length - 1;
      } else {
        active--;
      }

      updateClassActive(slides, dots);
      currentInterval = setInterval(() => {
        changeSlide();
      }, time);
    } else {
      clearInterval(currentInterval);
      if (active === slides.length - 1) {
        active = 0;
      } else {
        active++;
      }

      updateClassActive(slides, dots);
      currentInterval = setInterval(() => {
        changeSlide();
      }, time);
    }
  }
});

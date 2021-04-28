let slider;
let sliderItems = [];
let sliderIndex;
let sliderItemWidth;
let sliderWidth;

const run = () => {
  slider = document.querySelector('.slider');
  sliderItems = slider.querySelectorAll('.slider__item');
  slider.appendChild(sliderItems[0].cloneNode(true));
  slider.insertBefore(sliderItems[sliderItems.length - 1].cloneNode(true), sliderItems[0]);
  sliderItems = slider.querySelectorAll('.slider__item');
  sliderIndex = 1;

  const buttons = {
    prev: document.querySelector('.header__arrow .arrow__left'),
    next: document.querySelector('.header__arrow .arrow__right'),
  }
    buttons.next.addEventListener("click", () => swapSlide("right", checkSlide))
    buttons.prev.addEventListener("click", () => swapSlide("left", checkSlide));

  window.addEventListener("resize", () => {
    calculateSlider();
  });

  calculateSlider();
}

const checkSlide = (direction) => {
  if (direction === "right" && (sliderIndex + 1) === sliderItems.length) {
    sliderIndex = 1;
  }

  if (direction === "left" && (sliderIndex === 0)) {
    sliderIndex = sliderItems.length - 2;
  }

  slider.style.transform = "translate(" + -sliderIndex * (sliderItemWidth) + "px, 0)";
}

const swapSlide = (direction, check) => {

  if (direction === "right") {
    sliderIndex = (sliderIndex + 1) % sliderItems.length;
  }

  if (direction === "left") {
    sliderIndex = (sliderIndex - 1) % sliderItems.length;
  }

  slider.style.transition = ".3s ease-in-out";
  slider.style.transform = "translate(" + -sliderIndex * (sliderItemWidth) + "px, 0)";
  slider.addEventListener('transitionend', function() {
    slider.style.transition = '';
    check(direction);
  })

  changeBackground();
}

const calculateSlider = () => {
  slider.style.width = "";
  sliderItemWidth = slider.clientWidth;
  sliderWidth = sliderItemWidth * sliderItems.length;

  slider.style.width = sliderWidth + 'px';
  slider.style.transform = "translate(" + -sliderIndex * (sliderItemWidth) + "px, 0)";
  sliderItems.forEach((item) => {
    item.style.width = sliderItemWidth + 'px';
  });
}

const changeBackground = () => {
  const header = document.querySelector('.header');
  const currentSlide = sliderItems[sliderIndex];
  switch (currentSlide.id) {
    case ('hogwarts'):  {
      header.style.backgroundImage = 'url("./images/background-hogwarts.png")';
      break;
    }
    case ('casino'): {
      header.style.backgroundImage = "url('./images/background-city.png')";
      break;
    }
    case ('jordan'): {
      header.style.backgroundImage = "url('./images/background-jordan.png')";
      break;
    }
    case ('russia'): {
      header.style.backgroundImage = "url('./images/background-russia.png')";
      break;
    }
    default:
      header.style.background = "";
      break;
  }
}

window.onload = run;
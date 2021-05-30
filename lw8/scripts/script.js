class Slider {
  constructor() {
    this.header;
    this.headerClassList;
    this.slider;
    this.sliderItems = [];
    this.sliderIndex;
    this.sliderItemWidth;
    this.sliderWidth;
  }

  run = () => {
    this.header = document.querySelector('.header');
    this.headerClassList = this.header.className;
    this.slider = document.querySelector('.slider');
    this.sliderItems = this.slider.querySelectorAll('.slider__item');
    this.slider.appendChild(this.sliderItems[0].cloneNode(true));
    this.slider.insertBefore(this.sliderItems[this.sliderItems.length - 1].cloneNode(true), this.sliderItems[0]);
    this.sliderItems = this.slider.querySelectorAll('.slider__item');
    this.sliderIndex = 1;

    const buttons = {
      prev: document.querySelector('.header__arrow .arrow__left'),
      next: document.querySelector('.header__arrow .arrow__right'),
    }
    buttons.next.addEventListener("click", () => this.swapSlide("right", this.checkSlide))
    buttons.prev.addEventListener("click", () => this.swapSlide("left", this.checkSlide));

    window.addEventListener("resize", () => {
      this.calculateSlider();
    });

    this.calculateSlider();
    this.changeBackground();
  }

  checkSlide = (direction) => {
    if (direction === "right" && (this.sliderIndex + 1) === this.sliderItems.length) {
      this.sliderIndex = 1;
    }

    if (direction === "left" && (this.sliderIndex === 0)) {
      this.sliderIndex = this.sliderItems.length - 2;
    }

    this.slider.style.transform = "translate(" + -this.sliderIndex * (this.sliderItemWidth) + "px, 0)";
  }

  swapSlide = (direction, check) => {

    if (direction === "right") {
      this.sliderIndex = (this.sliderIndex + 1) % this.sliderItems.length;
    }

    if (direction === "left") {
      this.sliderIndex = (this.sliderIndex - 1) % this.sliderItems.length;
    }

    this.slider.style.transition = ".3s ease-in-out";
    this.slider.style.transform = "translate(" + -this.sliderIndex * (this.sliderItemWidth) + "px, 0)";
    this.slider.addEventListener('transitionend', function() {
      this.slider.style.transition = '';
      check(direction);
    }.bind(this));

    this.changeBackground();
  }

  calculateSlider = () => {
    this.slider.style.width = "";
    this.sliderItemWidth = this.slider.clientWidth;
    this.sliderWidth = this.sliderItemWidth * this.sliderItems.length;

    this.slider.style.width = this.sliderWidth + 'px';
    this.slider.style.transform = "translate(" + -this.sliderIndex * (this.sliderItemWidth) + "px, 0)";
    this.sliderItems.forEach((item) => {
      item.style.width = this.sliderItemWidth + 'px';
    });
  }

  changeBackground = () => {
    const currentSlide = this.sliderItems[this.sliderIndex];

    this.header.className = this.headerClassList;
    const currentSlideId = currentSlide.id;
    if (currentSlideId)
    {
      this.header.classList.add('background_' + currentSlideId);
    }
  }
}

const run = () => {
  const slider = new Slider();
  slider.run();
}

window.onload = run;

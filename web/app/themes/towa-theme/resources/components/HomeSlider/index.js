import $ from "jquery";
import "slick-carousel";

export default class HomeSlider {
  constructor(rootNode, props) {
    this.$rootNode = rootNode;
    this.props = JSON.parse(props);
    this.data = {};
    this.refs = {
      rootNode,
      prevArrow: this.$rootNode.querySelector(".HomeSlider__arrow-prev"),
      nextArrow: this.$rootNode.querySelector(".HomeSlider__arrow-next"),
      sidebar: this.$rootNode.querySelector(".HomeSlider__number_right"),
      viewCategories: [...document.getElementsByClassName("HomeSlider__link")],
      mainCounter: [...document.getElementsByClassName("HomeSlider__number01")],
      sideNumbers: this.$rootNode.querySelector(".HomeSlider__number_right")
        .children,
      headlines: [...document.getElementsByClassName("HomeSlider__headline")],
      abstracts: [...document.getElementsByClassName("HomeSlider__content")],
      number: [...document.getElementsByClassName("HomeSlider__number")],
      labels: [...document.getElementsByClassName("HomeSlider__label")],
      navbar: [...document.getElementsByClassName("Navbar")],
      scrollText: [...document.getElementsByClassName("HomeSlider__scrolltext")]
    };

    this.init();
    this.mounted();
    this.sidebar();

    this.state = {
      curIndex: 1,
      whichDirection: 1,
      onMenuClick: false
    };
    this.render();
    this.setupListeners();
  }

  setupListeners() {
    this.refs.prevArrow.addEventListener("click", () => {
      this.state.whichDirection = 0;
    });
    this.refs.nextArrow.addEventListener("click", () => {
      this.state.whichDirection = 1;
    });
    $(this.$refs.instance).on(
      "beforeChange",
      (event, slick, currentSlide, nextSlide) => {
        if (
          (currentSlide < nextSlide &&
            currentSlide === nextSlide - 1 &&
            !this.state.onMenuClick) ||
          (currentSlide === slick.slideCount - 1 &&
            nextSlide === 0 &&
            !this.state.onMenuClick)
        ) {
          this.state.whichDirection = 1;
        } else if (
          (nextSlide < currentSlide && !this.state.onMenuClick) ||
          (nextSlide === slick.slideCount - 1 &&
            currentSlide === 0 &&
            !this.state.onMenuClick)
        ) {
          this.state.whichDirection = 0;
        } else {
          this.state.whichDirection = 2;
          this.state.onMenuClick = false;
        }
        this.onChange();
      }
    );
    $(this.$refs.instance).on("afterChange", () => {
      this.onAfterChange();
    });

    this.onResize = this.onResize.bind(this);
    window.addEventListener("resize", this.onResize);

    for (let i = 0; i < this.refs.viewCategories.length; i++) {
      this.refs.viewCategories[i].addEventListener("click", () => {
        this.onViewCategoryClick();
      });
    }

    for (let i = 0; i < this.refs.sideNumbers.length; i++) {
      this.refs.sideNumbers[i].addEventListener("click", () => {
        this.onSideNumberClick(this.refs.sideNumbers[i].innerText);
      });
    }
  }

  onSideNumberClick(whichItem) {
    for (let i = 0; i < this.refs.sideNumbers.length; i++) {
      if (
        this.refs.sideNumbers[i].classList.contains(
          "HomeSlider__number_right_active"
        )
      ) {
        this.refs.sideNumbers[i].classList.remove(
          "HomeSlider__number_right_active"
        );
      }
      this.refs.sideNumbers[parseInt(whichItem, 10) - 1].classList.add(
        "HomeSlider__number_right_active"
      );
    }
    this.setState({ curIndex: parseInt(whichItem, 10) });
    this.state.whichDirection = 2;
    this.state.onMenuClick = true;
    $(".HomeSlider__item").slick("slickGoTo", parseInt(whichItem, 10) - 1);
  }

  onResize() {
    this.init();
  }

  onViewCategoryClick() {
    $("html, body").animate(
      {
        scrollTop: $("#PostGrid").offset().top
      },
      "slow"
    );
    e.preventDefault();
  }

  onChange() {
    if (this.state.whichDirection === 0) {
      this.onPrevClick();
    } else if (this.state.whichDirection === 1) {
      this.onNextClick();
    }
    // Headline disappear
    for (let i = 0; i < this.refs.headlines.length; i++) {
      this.refs.headlines[i].style.transform = "translateY(20px)";
      this.refs.headlines[i].style.opacity = "0";
    }
    // Content disappear
    for (let i = 0; i < this.refs.abstracts.length; i++) {
      this.refs.abstracts[i].style.transform = "translateY(20px)";
      this.refs.abstracts[i].style.opacity = "0";
    }

    // Buttons disappear
    for (let i = 0; i < this.refs.viewCategories.length; i++) {
      this.refs.viewCategories[i].style.transform = "translateY(20px)";
      this.refs.viewCategories[i].style.opacity = "0";
    }
  }

  onAfterChange() {
    // Headline re-appear
    for (let i = 0; i < this.refs.headlines.length; i++) {
      this.refs.headlines[i].style.transform = "translateY(-20px)";
      this.refs.headlines[i].style.opacity = "1";
    }

    // Content re-appear
    for (let i = 0; i < this.refs.abstracts.length; i++) {
      this.refs.abstracts[i].style.transform = "translateY(-20px)";
      this.refs.abstracts[i].style.opacity = "1";
    }

    // Buttons re-appear
    for (let i = 0; i < this.refs.viewCategories.length; i++) {
      this.refs.viewCategories[i].style.transform = "translateY(-20px)";
      this.refs.viewCategories[i].style.opacity = "1";
    }
  }

  onNextClick() {
    const numbers01 = [];
    this.refs.mainCounter.forEach((text01, i) => {
      if (this.refs.mainCounter[i].id) {
        numbers01.push(this.refs.mainCounter[i]);
      }
    });
    if (this.state.curIndex === numbers01.length) {
      this.setState({ curIndex: 1 });
    } else {
      this.setState({ curIndex: this.state.curIndex + 1 });
    }
  }

  onPrevClick() {
    const numbers01 = [];
    this.refs.mainCounter.forEach((text01, i) => {
      if (this.refs.mainCounter[i].id) {
        numbers01.push(this.refs.mainCounter[i]);
      }
    });

    if (this.state.curIndex <= 1) {
      this.setState({ curIndex: numbers01.length });
    } else {
      this.setState({ curIndex: this.state.curIndex - 1 });
    }
  }

  setState(newState) {
    this.state = Object.assign({}, this.state, newState);
    this.render();
  }

  get $refs() {
    return {
      instance: this.$rootNode.querySelectorAll(".HomeSlider__item"),
      prevArrow: this.$rootNode.querySelector(".HomeSlider__arrow-prev"),
      nextArrow: this.$rootNode.querySelector(".HomeSlider__arrow-next")
    };
  }

  init() {
    this.data = {
      slidesToShow: 1,
      slidesToScroll: 1
    };
    if (window.innerHeight <= 412) {
      this.refs.navbar[0].style.display = "none";
    } else {
      this.refs.navbar[0].removeAttribute("style");
    }
    if (window.innerHeight <= 412 && window.innerWidth <= 824) {
      for (let i = 0; i < this.refs.viewCategories.length; i++) {
        this.refs.headlines[i].style.fontSize = "32px";
        this.refs.headlines[i].style.lineHeight = "40px";
        this.refs.headlines[i].style.width = "400px";
        this.refs.abstracts[i].style.fontSize = "10px";
        this.refs.abstracts[i].style.lineHeight = "16px";
      }
      this.refs.prevArrow.style.width = "40px";
      this.refs.prevArrow.style.height = "40px";
      this.refs.prevArrow.style.right = "90px";
      this.refs.nextArrow.style.width = "40px";
      this.refs.nextArrow.style.height = "40px";
      this.refs.scrollText[0].style.marginBottom = "15px";
    } else {
      for (let i = 0; i < this.refs.viewCategories.length; i++) {
        this.refs.headlines[i].removeAttribute("style");
        this.refs.abstracts[i].removeAttribute("style");
      }
      this.refs.prevArrow.removeAttribute("style");
      this.refs.nextArrow.removeAttribute("style");
      this.refs.scrollText[0].removeAttribute("style");
    }
    if (window.innerHeight <= 650) {
      for (let i = 0; i < this.refs.viewCategories.length; i++) {
        this.refs.viewCategories[i].style.display = "none";
        this.refs.number[i].style.display = "none";
      }
    } else {
      for (let i = 0; i < this.refs.viewCategories.length; i++) {
        this.refs.viewCategories[i].style.display = "inline-block";
        this.refs.number[i].style.display = "block";
      }
    }
  }

  mounted() {
    $(this.$refs.instance).slick({
      slidesToShow: this.data.slidesToShow,
      slidesToScroll: this.data.slidesToScroll,
      autoplay: true,
      autoplaySpeed: 12000,
      prevArrow: this.$refs.prevArrow,
      nextArrow: this.$refs.nextArrow
    });
  }

  sidebar() {
    const arr = [...document.getElementsByClassName("HomeSlider__number01")];
    arr.forEach((text01, i) => {
      if (arr[i].id) {
        const span = document.createElement("div");
        span.classList.add("HomeSlider__sidebar_number");
        if (i > 9) {
          span.innerHTML = i;
        } else {
          span.innerHTML = `0${i}`;
        }
        this.refs.sidebar.appendChild(span);
      }
    });
  }

  render() {
    const test = [
      ...document.getElementsByClassName("HomeSlider__number_right")
    ];
    test[0].style.top = `${window.innerHeight / 2 -
      test[0].offsetHeight / 2}px`;
    const arr2 = [...document.getElementsByClassName("HomeSlider__number02")];
    const numbers02 = [];
    arr2.forEach((text01, i) => {
      if (arr2[i].id) {
        numbers02.push(arr2[i]);
      }
    });
    numbers02.forEach(secondNumber => {
      secondNumber.innerHTML = `0${numbers02.length}`;
    });
    const sidebarNumbers = [
      ...document.getElementsByClassName("HomeSlider__sidebar_number")
    ];
    const numbers = [];
    sidebarNumbers.forEach((number, i) => {
      numbers.push(sidebarNumbers[i].innerHTML);
      numbers[i] = numbers[i].split(0);
      numbers[i].splice(0, 1);
      if (parseInt(numbers[i], 10) === this.state.curIndex) {
        number.classList.add("HomeSlider__number_right_active");
      } else {
        number.classList.remove("HomeSlider__number_right_active");
      }
    });

    if (this.state.curIndex < 9) {
      this.refs.mainCounter.forEach((text01, i) => {
        if (this.refs.mainCounter[i].id) {
          text01.innerHTML = `0${this.state.curIndex}`;
        }
      });
    }
  }
}

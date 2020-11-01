import $ from "jquery";
import "slick-carousel";

export default class PostSlider {
  constructor(rootNode, props) {
    this.$rootNode = rootNode;
    this.props = JSON.parse(props);
    this.data = {};
    this.state = {
      whichDirection: 1
    };
    this.refs = {
      rootNode,
      instance: this.$rootNode.querySelectorAll(".PostSlider__item"),
      prevArrow: this.$rootNode.querySelector(".PostSlider__arrow-prev"),
      nextArrow: this.$rootNode.querySelector(".PostSlider__arrow-next"),
      number: this.$rootNode.querySelector(".PostSlider__number")
    };

    this.init();
    this.mounted();
  }

  init() {
    this.data = {
      slidesToShow: 1,
      slidesToScroll: 1
    };
    $(this.refs.instance).on(
      "beforeChange",
      (event, slick, currentSlide, nextSlide) => {
        this.onChange(nextSlide);
      }
    );
  }
  onChange(nextSlide) {
    this.refs.number.innerText = `0${nextSlide + 1}`;
    if (this.refs.number.innerText === "01") {
      $(".PostSlider__number")[0].removeAttribute("style");
    } else {
      $(".PostSlider__number")[0].style.left = "-15px";
    }
  }

  mounted() {
    $(this.refs.instance).slick({
      slidesToShow: this.data.slidesToShow,
      slidesToScroll: this.data.slidesToScroll,
      prevArrow: this.refs.prevArrow,
      nextArrow: this.refs.nextArrow
    });
  }
}

import $ from 'jquery';
import 'slick-carousel';
import './example.jpg';
import '../../assets/img/example2.jpg';
import './congress.svg';

export default class Slider {
  constructor(rootNode, props) {
    this.$rootNode = rootNode;
    this.props = JSON.parse(props);
    this.data = {};

    this.init();
    this.mounted();
  }

  get $refs() {
    return {
      instance: this.$rootNode.querySelectorAll('.Slider__item'),
      prevArrow: this.$rootNode.querySelector('.Slider__arrow-prev'),
      nextArrow: this.$rootNode.querySelector('.Slider__arrow-next'),
    };
  }

  init() {
    this.data = {
      slidesToShow: 1,
      slidesToScroll: 1,
    };
  }

  mounted() {
    $(this.$refs.instance).slick({
      slidesToShow: this.data.slidesToShow,
      slidesToScroll: this.data.slidesToScroll,
      prevArrow: this.$refs.prevArrow,
      nextArrow: this.$refs.nextArrow,
    });
  }
}

<script>
import { swiper, swiperSlide } from 'vue-awesome-swiper';

export default {
  props: {
    sliderOptions: {
      type: Object,
      default: null,
    },
    withNavigation: {
      type: Boolean,
      default: false,
    },
    withPagination: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      defaultOptions: {
        slidesPerView: 1,
        autoHeight: true,
        loop: true,
        keyboard: {
          enabled: true,
          onlyInViewport: true,
        },
      },
      allSlidesInView: false,
    };
  },
  computed: {
    options() {
      return {
        ...this.defaultOptions,
        ...this.checkNavigation(),
        ...this.checkPagination(),
        ...this.sliderOptions,
      };
    },
    hideNav() {
      return !this.withNavigation || this.allSlidesInView;
    },
    hidePagination() {
      return !this.withPagination || this.allSlidesInView;
    },
  },
  methods: {
    checkNavigation() {
      if (this.hideNav) return null;

      return {
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      };
    },
    checkPagination() {
      if (this.hidePagination) return null;

      let paginationOptions = {
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
      };

      if (!this.$slots['pagination']) {
        paginationOptions = {
          pagination: {
            ...paginationOptions.pagination,
            renderBullet: (idx, className) =>
              `<button role="button" aria-label="Go to slide ${idx + 1}" class="${className}"></button>`,
          },
        };
      }

      return paginationOptions;
    },
    // wraps each node in the slide slots in a "swiper-slide" component
    wrapSlotsInSlides(createEl) {
      return this.$slots.slides.reduce((slides, slideNode) => {
        if (slideNode.tag) {
          // createEl takes in an array so we need to wrap the vNode
          slides.push(createEl(swiperSlide, null, [slideNode]));
        }
        return slides;
      }, []);
    },
    getNavigation(createEl) {
      if (this.hideNav) return null;

      // button styling in object form
      const prevClass = { class: { 'swiper-button-prev': true, 'swiper-button': true } };
      const nextClass = { class: { 'swiper-button-next': true, 'swiper-button': true } };

      return {
        prevButton: this.$slots['button-prev'] || createEl('button', prevClass, ''),
        nextButton: this.$slots['button-next'] || createEl('button', nextClass, ''),
      };
    },
    // create new pagination markup if the slot is empty
    getPagination(createEl) {
      if (this.hidePagination) return null;

      if (this.$slots['pagination']) {
        return this.$slots['pagination'];
      }

      return createEl('div', { class: { 'swiper-pagination': true } }, '');
    },
  },
  render(createEl) {
    const slideNodes = this.wrapSlotsInSlides(createEl);
    this.allSlidesInView = this.options.slidesPerView >= slideNodes.length;
    const navSlot = this.getNavigation(createEl);
    const paginationSlot = this.getPagination(createEl);

    const params = {
      props: {
        options: this.options,
      },
      scopedSlots: {
        'button-prev': () => navSlot && navSlot.prevButton,
        'button-next': () => navSlot && navSlot.nextButton,
        pagination: () => paginationSlot,
      },
    };
    const swiperNode = createEl(swiper, params, slideNodes);

    return createEl('div', { class: { Slider__container: true } }, [swiperNode]);
  },
};
</script>

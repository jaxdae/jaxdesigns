<template>
  <header
    :style="{height: navHeight+'px'}"
    role="banner"
  >
    <nav
      ref="nav"
      :class="{Nav:true, navopen, subnavopen}"
      role="navigation"
    >
      <slot
        v-if="!navBreadcrumb"
        name="logo"
      />
      <div
        v-if="navBreadcrumb"
        class="Nav__breadcrumbs"
      >
        <button
          class="Nav__button--back"
          aria-label="Navigation: go back"
          @click="toggleSubNav()"
        />
        <span>{{ navBreadcrumb }}</span>
      </div>
      <div class="Nav__wrapper">
        <ul class="Nav__list">
          <li
            v-for="item in navList"
            :key="item.id"
            :class="`Nav__item ${item.class || ''}`"
          >
            <a
              :href="item.url"
              class="Nav__link"
              :target="item.target"
              v-html="item.name"
            />
            <button
              v-if="hasSubnav(item)"
              class="Nav__subnav--button"
              @click="toggleSubNav(item)"
            >
              <i class="icon" />
            </button>
            <subnav
              v-if="hasSubnav(item)"
              ref="subnav"
              :class="{'Nav__subnav--open':item.open && navopen}"
              :subnav="item.children"
              :allow-scroll="item.open"
            />
          </li>
        </ul>
      </div>
      <button
        class="MobileNav__toggle"
        :class="{'MobileNav__toggle--cross': navopen, navopen}"
        @click="toggleNav"
      >
        <span />
        <span />
        <span v-if="!navopen" />
      </button>
    </nav>
  </header>
</template>
<script>
import { disableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';
import Subnav from './Subnav.vue';

export default {
  components: {
    subnav: Subnav,
  },
  props: {
    nav: {
      type: Array,
      default: () => null,
      required: true,
    },
    slug: {
      type: String,
      default: () => '',
    },
  },
  data() {
    return {
      navopen: false,
      subnavopen: false,
      navBreadcrumb: null,
      navList: this.nav,
      navHeight: 0,
    };
  },
  mounted() {
    this.$nextTick(() => window.addEventListener('resize', this.handleResize));
    this.handleResize();
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    handleResize() {
      if (window.innerWidth >= 1279) {
        this.navopen = false;
      }
      if (this.$refs.hasOwnProperty('nav')) {
        this.navHeight = this.$refs.nav.offsetHeight;
      }
    },
    resetNav() {
      this.navBreadcrumb = null;
      this.subnavopen = false;
      this.navList.map(item => {
        item.open = false;
        return item;
      });
    },
    toggleNav() {
      this.navopen = !this.navopen;
      this.navopen ? disableBodyScroll(this.$refs.nav.querySelector('.Nav__list')) : clearAllBodyScrollLocks();

      this.resetNav();
    },
    hasSubnav(navItem) {
      return navItem.children && navItem.children.length > 0;
    },
    toggleSubNav(item = null) {
      if (item) {
        item.open = !item.open;
        this.subnavopen = !this.subnavopen;
        this.navBreadcrumb = this.navBreadcrumb ? null : item.name;
      } else {
        this.resetNav();
      }
    },
  },
};
</script>

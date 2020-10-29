<template>
  <div
    :class="{'Nav__subnav-container': level === 1, 'Nav__subnav--complex': level>1}"
  >
    <ul
      :ref="`subnav-${level}`"
      class="Nav__subnav"
    >
      <li
        v-for="subitem in subnav"
        :key="subitem.id"
        :class="{'Nav__subitem':true}"
      >
        <a
          :href="subitem.url"
          :class="`Nav__sublink ${subitem.class || ''}`"
          :target="subitem.target"
        >
          <p
            class="Nav__subitem-name"
            :class="{'Nav__subitem-headline': hasSubnav(subitem)}"
            v-text="subitem.name"
          />
        </a>
        <subnav
          v-if="hasSubnav(subitem)"
          :subnav="subitem.children"
          :level="level+1"
        />
      </li>
    </ul>
  </div>
</template>
<script>
import { disableBodyScroll } from 'body-scroll-lock';

export default {
  name: 'Subnav',
  props: {
    level: {
      type: Number,
      default: () => 1,
    },
    subnav: {
      type: [Array],
      default: () => null,
    },
    allowScroll: {
      type: Boolean,
      default: () => false,
    },
  },
  watch: {
    allowScroll(newVal, oldVal) {
      if (newVal && this.level === 1) {
        disableBodyScroll(this.$refs[`subnav-${this.level}`]);
      }
    },
  },
  methods: {
    hasSubnav(navItem) {
      return navItem.children && navItem.children.length > 0;
    },
  },
};
</script>

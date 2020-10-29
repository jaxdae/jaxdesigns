<template>
  <a
    :href="post.link"
    class="Card"
  >
    <picture
      v-if="post.image"
      class="Card__picture"
    >
      <source
        :srcset="post.image.sizes.i480x270"
        media="(max-width: 480px)"
      >
      <img
        :src="post.image.sizes.i768x432"
        :alt="post.image.alt"
        class="Card__image"
      >
    </picture>

    <div class="Card__wrapper"><h3
      class="Card__title"
      v-text="post.title"
    /></div>
  </a>
</template>

<script>
export default {
  props: {
    post: {
      type: Object,
      default: () => {},
    },
  },
};
</script>

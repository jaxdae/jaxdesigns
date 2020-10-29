<template>
  <figure class="Video">
    <div class="Video__wrapper">
      <div
        :id="playerId"
        class="Video__item"
      />
      <picture
        v-if="image && !isPlaying"
        class="Video__picture"
      >
        <source
          media="(min-width: 1280px)"
          :srcset="image.sizes.i920x517"
        >
        <source
          media="(min-width: 768px)"
          :srcset="image.sizes.i768x432"
        >
        <source
          media="(min-width: 0)"
          :srcset="image.sizes.i480x270"
        >
        <img
          class="Video__image"
          :src="image.sizes.i920x517 "
          :alt="image.alt"
          :title="image.title"
        >
      </picture>
      <button
        v-if="!isPlaying"
        class="Video__overlay"
        @click="playVideo"
      >
        Play
      </button>
    </div>
    <slot />
  </figure>
</template>
<script>
export default {
  name: 'Video',
  props: {
    playerId: {
      type: String,
      required: true,
    },
    videoId: {
      type: String,
      required: true,
    },
    image: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isPlaying: false,
      playerIsReady: false,
      player: null,
    };
  },
  methods: {
    playVideo() {
      this.createYoutube();
      this.isPlaying = true;
    },
    createYoutube() {
      const tag = document.createElement('script');

      tag.src = '//www.youtube.com/iframe_api';
      const firstScriptTag = document.body.getElementsByTagName('script')[0];

      if (firstScriptTag.src.indexOf('iframe_api') !== -1) {
        if (this.player && this.playerIsReady) {
          this.player.playVideo();
        } else {
          this.onYouTubeIframeAPIReady();
        }

        return;
      }

      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      window.onYouTubeIframeAPIReady = () => this.onYouTubeIframeAPIReady();
    },
    onYouTubeIframeAPIReady() {
      /* eslint-disable no-undef */
      this.player = new YT.Player(this.playerId, {
        height: '720',
        width: '1280',
        // protocoll necessary for onReady event
        host: window.location.protocol + '//www.youtube-nocookie.com',
        videoId: this.videoId,
        playerVars: {
          autoplay: 1,
          rel: 0,
          modestbranding: 1,
          mute: 0,
          enablejsapi: 1,
          origin: window.location.origin,
        },
        events: {
          onReady: e => {
            this.playerIsReady = true;

            e.target.mute();
            e.target.playVideo();
          },
        },
      });
    },
  },
};
</script>

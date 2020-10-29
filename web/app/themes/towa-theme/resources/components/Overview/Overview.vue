<template>
  <div v-cloak>
    <div class="Overview__wrapper">
      <div
        v-if="terms.length"
        class="Overview__filters"
      >
        <button
          v-for="(term, index) in terms"
          :key="index"
          :class="{ active: term === currTerm }"
          :data-filter="term.id"
          :disabled="callInProgress"
          class="Overview__filter"
          @click="currTerm = term"
          v-text="term.name"
        />
      </div>
      <!-- select mobile -->
      <Multiselect
        v-if="terms.length"
        v-model="currTerm"
        :show-labels="false"
        :allow-empty="false"
        :options="terms"
        :searchable="false"
        track-by="id"
        label="name"
        class="selectbox"
      />

      <transition-group
        appear
        tag="div"
        class="Overview__items"
        name="fade"
      >
        <component
          :is="cpt + '-item'"
          v-for="post in posts"
          :key="post.id"
          :post="post"
        />
      </transition-group>

      <div
        v-if="!callInProgress"
        class="button-wrapper"
      >
        <button
          :disabled="loadMoreDisabled"
          class="Overview__button"
          @click.prevent="fetchPosts({ termId: currTerm.id, count: loadMoreCount })"
        >
          {{ loadMoreText }}
        </button>
      </div>

      <transition name="fade">
        <div
          v-if="callInProgress"
          class="spinner"
        >
          <div class="spinner-rect" />
          <div class="spinner-rect" />
          <div class="spinner-rect" />
          <div class="spinner-rect" />
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import PageItem from './../PageItem.vue';
import multiselect from 'vue-multiselect';

export default {
  components: { PageItem, multiselect },

  props: {
    taxonomy: {
      type: String,
      default: '',
    },
    cpt: {
      type: String,
      required: true,
    },
    initialLoadCount: {
      type: [String, Number],
      default: 12,
    },
    loadMoreCount: {
      type: [String, Number],
      default: 6,
    },
    loadMoreText: {
      type: String,
      default: 'load more',
    },
  },

  data() {
    return {
      posts: [],
      terms: [],
      currTerm: {},
      postsRemaining: true,
      callInProgress: false,
    };
  },

  computed: {
    loadMoreDisabled() {
      return !this.posts.length || this.callInProgress || !this.postsRemaining;
    },
  },

  watch: {
    currTerm() {
      this.fetchPosts({
        initial: true,
        count: this.initialLoadCount,
        termId: this.currTerm.id,
      });
    },
  },

  created() {
    this.fetchTerms();
    this.fetchPosts({
      initial: true,
      count: this.initialLoadCount,
    });
  },

  methods: {
    loadMore(resetAutoload = false) {
      if (this.loadMoreDisabled) {
        return;
      }

      if (resetAutoload) {
        this.autoloadCount = 0;
      }

      this.fetchPosts({
        count: this.loadMoreCount,
        termId: this.currTerm.id,
      });
    },

    fetchTerms() {
      if (!this.taxonomy) return;

      axios
        .get(api.terms + this.taxonomy, {
          params: {
            cpt: this.cpt,
          },
        })
        .then(response => {
          this.terms = response.data.terms;

          this.currTerm = this.terms.find(t => t.active);
        })
        .catch(() => {
          this.message = 'Keine Daten vorhanden';
        });
    },

    fetchPosts(options) {
      this.callInProgress = true;

      if (options.initial) {
        this.posts = [];
        this.postsRemaining = true;
      }

      axios
        .get(api.posts + this.cpt, {
          params: {
            taxonomy: this.taxonomy,
            termId: options.termId || null,
            offset: options.initial ? null : this.posts.length,
            count: options.count || null,
          },
        })
        .then(response => {
          if (response.data.done) {
            this.postsRemaining = false;
          }

          this.callInProgress = false;

          if (options.initial) {
            this.posts = response.data.posts;
          } else {
            response.data.posts.forEach(p => this.posts.push(p));
          }
        })
        .catch(() => {
          this.callInProgress = false;
        });
    },
  },
};
</script>

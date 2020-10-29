import './styles/main.scss';
import 'core-js/stable';
import 'regenerator-runtime/runtime';

// import components from './components';
import * as components from './components';

import Vue from 'vue';
import Overview from '@components/Overview/Overview';
import Slider from '@components/Slider/Slider';
import Navigation from '@components/Nav/Navigation';
import VideoModule from '@components/Video/VideoModule';

Vue.component('overview', Overview);
Vue.component('slider', Slider);
Vue.component('navigation', Navigation);
Vue.component('video-module', VideoModule);

/* eslint-disable no-unused-vars */
const app = new Vue({
  el: '#app',
});

document.addEventListener('DOMContentLoaded', () => {
  const componentNodes = [...document.querySelectorAll('[data-component]')];

  componentNodes.forEach(node => {
    const props = node.getAttribute('data-props');
    const componentName = node.getAttribute('data-component');

    /* eslint-disable no-new */
    new components[componentName](node, JSON.parse(props));
  });
});

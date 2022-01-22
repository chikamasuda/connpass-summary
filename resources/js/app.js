require('./bootstrap');
import Vue from 'vue';
import EventLike from './components/EventLike'


const app = new Vue({
  el: '#app',
  components: {
    EventLike,
  }
})
require('./bootstrap');
import Vue from 'vue';
import EventLike from './components/EventLike'
import DeleteLike from './components/DeleteLike'


const app = new Vue({
  el: '#app',
  components: {
    EventLike,
    DeleteLike,
  }
})
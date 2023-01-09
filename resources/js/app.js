import Vue from 'vue';
import VModal from 'vue-js-modal';
import App from './App.vue';

Vue.use(VModal);

const app = new Vue({
  el: '#app',
  name: 'Root',
  components: { App },
});

export default app;

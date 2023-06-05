require('./bootstrap');
window.Vue = require('vue');
import router from './router';
import store from './store';
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import 'dragula/dist/dragula.css';
import Vue from 'vue';
import VueHtmlToPaper from 'vue-html-to-paper';
import VueSession from 'vue-session'
Vue.use(VueSession)

Vue.use(ViewUI);
import common from './common';
Vue.mixin(common);



import { Vue2Dragula } from 'vue2-dragula'
Vue.use(Vue2Dragula);

// import VueWebsocket from "vue-websocket";
// Vue.use(VueWebsocket, "ws://192.168.254.105:8080");

const options = {
    name: 'ORDER SLIP',
    specs: [
      'fullscreen=yes',
      'titlebar=yes',
      'scrollbars=yes',
      'silent=yes'
    ],
 
    
  }
  
Vue.use(VueHtmlToPaper, options);
Vue.use(VueHtmlToPaper);


Vue.component('mainapp', require('./components/mainapp.vue').default);
const app = new Vue({
    el: '#app',
    router,
    store
})








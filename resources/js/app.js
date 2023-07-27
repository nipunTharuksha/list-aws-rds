require('./bootstrap');
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import Alpine from 'alpinejs';


window.Alpine = Alpine;

Alpine.start();

import {createApp} from 'vue'
import router from './router'

const app = createApp({})
app.use(VueLoading);
app.use(router)
app.use(VueAxios, axios)
app.provide('axios', app.config.globalProperties.axios)  // provide 'axios'
app.mount('#app');

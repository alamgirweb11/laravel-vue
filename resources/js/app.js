/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');
import Vue from 'vue'
import VueProgressBar from 'vue-progressbar'
import Form from 'vform'
import Snotify, { SnotifyPosition } from 'vue-snotify'

window.Form = Form;

// import App from './App'

// vue progress-bar option 
const VueProgressBarOptions = {
  color: '#32a63b',
  failedColor: '#de0d1b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.2s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}



Vue.use(VueProgressBar, VueProgressBarOptions)


// snotify options
const snotifyOptions = {
  toast: {
    position: SnotifyPosition.rightTop,
    closeOnClick: true,
    timeout: 2000,
    showProgressBar: true,
    pauseOnHover: false
  }
}

Vue.use(Snotify, snotifyOptions)




/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('customer-manage', require('./components/CustomerManage.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

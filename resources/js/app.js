/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import moment from 'moment';
import Form from 'vform';
import { HasError, AlertError } from 'vform/src/components/bootstrap5';

import XLSX from 'vue-xlsx';

import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);

Window.form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('Pagination', require('laravel-vue-pagination'));

import Vue from 'vue'
import VueRouter from 'vue-router'
import Swal from 'sweetalert2'

Window.Swal = Swal;

Vue.use(VueRouter)

let routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/users', component: require('./components/Users.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default },
  { path: '*', component: require('./components/NotFound.vue').default },
]

const router = new VueRouter({
  routes: routes, // short for `routes: routes`
  mode: 'history',
})

Vue.filter('upText', function(text){
  return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('myDate', function(created){
  return moment(created).format('MMMM Do YYYY');
});

window.Fire = new Vue();

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('job-posting-component', require('./components/JobPostingComponent.vue').default);
Vue.component('example-component', require('./components/WelcomeComponent.vue').default);
Vue.component('not-found', require('./components/NotFound.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    // data: {
    //   search: '',
    // },
    // methods: {
    //   searchIt: _.debounce(() => {
    //     Fire.$emit('searching');
    //   }, 1000)
    // },
});

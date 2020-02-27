/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import fileUpload from "./js/fileUpload";
import NavbarClass from "./js/navbar";
import Home from './js/home';

require('./bootstrap');

window.Vue = require('vue');

const navbarClassInstance = new NavbarClass();
const fileUploadInstance = new fileUpload();
const homeInstance = new Home();
navbarClassInstance.navbarToggleAnimation();
navbarClassInstance.scrollVertically();
window.selectFile = fileUploadInstance.selectFile.bind(fileUploadInstance);
window.readUrl = fileUploadInstance.readUrl.bind(fileUploadInstance);
window.toggleLogin = navbarClassInstance.toggleLogin.bind(navbarClassInstance);
window.toggleDetailsBox = navbarClassInstance.toggleDetailsBox.bind(navbarClassInstance);
window.goToProducts = homeInstance.goToProducts.bind(homeInstance);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/main-products-card.vue -> <main-products-card></main-products-card>
 */

// var files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('main-products-card', require('./components/main-products-card.vue').default);
Vue.component('main-product-info-card', require('./components/main-product-info-card.vue').default);
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
if(document.getElementById("productsApp")){
    const app = new Vue({
        el: '#productsApp',
    });
}

if(document.getElementById("productApp")){
    const productApp = new Vue({
        el: '#productApp',
    });
}



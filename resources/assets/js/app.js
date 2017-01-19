
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

/*
Vue.component('example', require('./components/Example.vue'));
 */

Vue.component('user-index', require('./components/user/UserIndex.vue'));
Vue.component('user-create', require('./components/user/UserCreate.vue'));
Vue.component('user-edit', require('./components/user/UserEdit.vue'));

Vue.component('role-index', require('./components/role/RoleIndex.vue'));
Vue.component('role-create', require('./components/role/RoleCreate.vue'));
Vue.component('role-edit', require('./components/role/RoleEdit.vue'));


const app = new Vue({
    el: '#app'
});

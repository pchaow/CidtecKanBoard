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
 var VueDragula = require('vue-dragula');
 Vue.use(VueDragula);
 Vue.config.debug = true

/*
 Vue.component('example', require('./components/Example.vue'));
 */

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);


Vue.component('user-index', require('./components/user/UserIndex.vue'));
Vue.component('user-create', require('./components/user/UserCreate.vue'));
Vue.component('user-edit', require('./components/user/UserEdit.vue'));

Vue.component('role-index', require('./components/role/RoleIndex.vue'));
Vue.component('role-create', require('./components/role/RoleCreate.vue'));
Vue.component('role-edit', require('./components/role/RoleEdit.vue'));

Vue.component('user-board-new', require('./components/userBoard/UserBoardNew.vue'));
Vue.component('user-board-index', require('./components/userBoard/UserBoardIndex.vue'));
Vue.component('user-board-view', require('./components/userBoard/UserBoardView.vue'));
Vue.component('user-board-edit', require('./components/userBoard/UserBoardEdit.vue'));



const app = new Vue({
    el: '#app'
});

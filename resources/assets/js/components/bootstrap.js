require('./module/_register');
require('./shared/_register');

Vue.component('user-list', require('./user/user-list.vue'));
Vue.component('client-list', require('./client/client-list.vue'));
Vue.component('project-list', require('./project/project-list.vue'));

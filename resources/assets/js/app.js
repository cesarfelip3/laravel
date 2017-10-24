require('./vendor');

import Utils from './commons/utils';

window.Utils = Utils();

import Layout from './commons/layout';

window.Layout = Layout();

import Laroute from './commons/laroute';

window.laroute = Laroute;

window.Pusher = require('pusher-js');
Pusher.logToConsole = true;

import Echo from "laravel-echo";

if (Slc.pusher_app_key) {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: Slc.pusher_app_key,
        cluster: 'us2',
    });
}

window.Vue = require('vue');
require('./components/bootstrap');

window.Bus = new Vue();
require('./vue/bootstrap');


const app = new Vue({
        el: '#app',

        data() {
            return {
                user: 'Slc' in window ? Slc.user : null,
                isMenuVisible: true,
            }
        },

        created() {
            console.log("App Created");
            window.Layout.init();
            let self = this;
            Bus.$on('loadCurrentUser', () => {
                axios.get(laroute.route('api.current.user'))
                    .then(response => {
                        self.user = response.data;
                    });
            });
            if (Slc.pusher_app_key && this.user && this.user.id) {
                window.Echo.private(`App.User.${this.user.id}`)
                    .listen('DemoEventReceived', (e) => {
                        console.log("Event", e);
                    });
            }
        },
    })
;

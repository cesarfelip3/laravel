require('./vendor');

import Utils from './commons/utils';
window.Utils = Utils();

import Layout from './commons/layout';
window.Layout = Layout();

import Laroute from './commons/laroute';
window.laroute = Laroute;


window.Vue = require('vue');
require('./components/bootstrap');

window.Bus = new Vue();
require('./vue/bootstrap');


const app = new Vue({
        el: '#app',

        data(){
            return {
                user: 'Slc' in window ? Slc.user : null,
                isMenuVisible: true,
            }
        },

        created()
        {
            console.log("App Created");
            window.Layout.init();
            let self = this;
            Bus.$on('loadCurrentUser', () => {
                axios.get(laroute.route('api.current.user'))
                    .then(response => {
                        self.user = response.data;
                    });
            });
        },
    })
;

import _ from 'lodash';
window._ = _;

import jQUery from 'jquery';
window.$ = window.jQuery = jQUery;

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

import Sparkline from 'jquery-sparkline';
window.$.sparkline = Sparkline;

require('sweetalert');
require('metismenu');
require('bootstrap-sass');
require('pace');

window.toastr = require('toastr');
toastr.options = {
    "closeButton": true,
    "debug": false,
    "progressBar": true,
    "preventDuplicates": false,
    "positionClass": "toast-top-right",
    "onclick": null,
    "showDuration": "400",
    "hideDuration": "1000",
    "timeOut": "7000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
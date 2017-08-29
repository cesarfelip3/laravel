import Sortable from 'sortablejs';
Vue.directive('sortable', {
    inserted: function (el, binding) {
        new Sortable(el, binding.value || {})
    }
});

import ToggleButton from 'vue-js-toggle-button';
Vue.use(ToggleButton);

Vue.component('multiselect', require('vue-multiselect'));

require('./form');
require('./errors');
if( 'Slc' in window )  {
    $.extend(Slc, require('./http'));
}


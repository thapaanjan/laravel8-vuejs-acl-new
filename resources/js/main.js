import Vue from 'vue';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import App from './components/App';
import router from './router';
import common from './common';
import store from './store';
import Swal from 'sweetalert2'
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faUser,
    faUserCircle,
    faEye,
    faSignOutAlt,
    faHome,
    faUserCog,
    faClone,
    faEdit,
    faTrashAlt,
    faUserLock,
    faBars,
    faUsersCog,
    faUsers
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
faSignOutAlt
library.add(faUser, faUserCircle, faEye, faSignOutAlt, faHome, faUserCog, faClone, faEdit, faTrashAlt, faUserLock, faBars, faUsers, faUsersCog);
Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.mixin(common);
Vue.use(VueToast, {
    position: 'bottom'
});
Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        'main-app': App,
    }
});
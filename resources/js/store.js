import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        resourcePermission: null,
    },
    getters: {
        getAdminPermissions(state) {
            // sending admin permission to entire application.
            return state.resourcePermission;
        },
    },
    mutations: {
        setAdminPermission(state, data) {
            // storing permission data into resourcePermission variable in state function
            state.resourcePermission = data;
        },
    },
    actions: {}
});
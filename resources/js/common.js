import axios from "axios";
import ThemifyIcon from "vue-themify-icons";
import { mapGetters } from "vuex";

export default {
    components: {
        ThemifyIcon,
    },
    data() {
        return {

        }
    },
    created() {},
    methods: {
        async callApi(method, url, dataObject) {
            try {
                return await axios({
                    method: method,
                    url: '/api/v1/' + url,
                    data: dataObject
                });
            } catch (error) {
                console.log(error)
                return error.response;
            }
        },
        warning(message) {
            this.$toast.open({
                message: message,
                type: "warning",
                duration: 2500,
                dismissible: true
            });
        },
        success(message) {
            this.$toast.open({
                message: message,
                type: "success",
                duration: 2500,
                dismissible: true
            });
        },
        error(message) {
            this.$toast.open({
                message: message,
                type: "error",
                duration: 2500,
                dismissible: true
            });
        },

        checkAdminPermission(key) {
            if (!this.adminPermissions) return true;
            let isPermitted = false
            for (let permission of this.adminPermissions) {
                if (key === permission.slug) {
                    isPermitted = true;
                    break;
                }
            }
            return isPermitted;
        }
    },
    computed: {

        // getting permission from store.js file using getAdminPermissions method and storing in userPermission variable
        ...mapGetters({
            'adminPermissions': 'getAdminPermissions',
        }),
        // ...mapGetters(["getAdminPermissions"]),

        // checking write inside pages
        isWritePermitted() {
            return this.checkAdminPermission('add')
        },
        // checking update inside pages
        isUpdatePermitted() {
            return this.checkAdminPermission('update')
        },
        // checking delete inside pages
        isDeletePermitted() {
            return this.checkAdminPermission('delete')
        },
        isManagePermission() {
            return this.checkAdminPermission('manage_permission')
        },
    },
    mounted() {}
}
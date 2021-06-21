import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './pages/Home';
import Resources from './pages/Resources';
import Teams from './pages/Teams';
import Users from './pages/Users';
import Roles from './pages/Roles';

Vue.use(VueRouter);

const routes = [{
        path: "/",
        component: Home,
        name: "dashboard",
        meta: {
            title: 'Dashboard'
        }
    },
    {
        path: "/resources",
        component: Resources,
        name: "resources",
        meta: {
            title: 'Resources'
        }
    },
    {
        path: "/teams",
        component: Teams,
        name: "teams",
        meta: {
            title: 'Teams'
        }
    },
    {
        path: "/users",
        component: Users,
        name: "users",
        meta: {
            title: 'Users'
        }
    },
    {
        path: "/roles",
        component: Roles,
        name: "roles",
        meta: {
            title: 'Roles'
        }
    }
];

const router = new VueRouter({
    mode: "history",
    routes
})

router.beforeEach((to, from, next) => {
    const mainTitle = "Laravel Vue ACL Admin Panel";
    document.title = `${to.meta.title} |  ${ mainTitle }`;
    next();
});

export default router;
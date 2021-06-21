<template>
    <div>
        <div id="main-wrapper">
            <header class="topbar">
                <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                    <div class="navbar-header">
                        <a href="/" class="navbar-brand">
                            <b>
                                <img
                                    src="images/logo.png"
                                    alt="homepage"
                                    class="light-logo"
                                />
                            </b>
                            <span>
                                <img
                                    src="images/logo-text.png"
                                    class="light-logo"
                                    alt="homepage"
                                />
                            </span>
                        </a>
                    </div>
                    <div class="navbar-collapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a
                                    class="
                                        nav-link nav-toggler
                                        d-block d-md-none
                                        waves-effect waves-dark
                                    "
                                    href="javascript:void(0)"
                                >
                                    <font-awesome-icon icon="bars" class="bars"/>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="
                                        nav-link
                                        sidebartoggler
                                        d-none d-lg-block d-md-block
                                        waves-effect waves-dark
                                    "
                                    href="javascript:void(0)"
                                    ><font-awesome-icon icon="bars" class="bars" />
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav my-lg-0">
                           
                            <li class="nav-item">
                                <span class="nav-link"
                                    style="color: #fff !important">Hello {{loggedInName}} <font-awesome-icon icon="user" class="user"/>
                                </span>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="left-sidebar">
                <div class="scroll-sidebar">
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li>
                                <router-link
                                    to="/"
                                    class="waves-effect waves-dark"
                                    aria-expanded="false"
                                    v-if="showDashboard"
                                    exact
                                >
                                    <font-awesome-icon icon="home" />
                                    <span class="hide-menu">
                                        Dashboard</span
                                    ></router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/roles"
                                    class="waves-effect waves-dark"
                                    aria-expanded="false"
                                    exact
                                    v-if="showRoles"
                                    ><font-awesome-icon icon="user-cog" />
                                    <span class="hide-menu"
                                        >Roles</span
                                    ></router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/resources"
                                    class="waves-effect waves-dark"
                                    exact
                                    aria-expanded="false"
                                    v-if="showResources"
                                >
                                    <font-awesome-icon icon="clone" />
                                    <span class="hide-menu"
                                        >Resources List</span
                                    ></router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/teams"
                                    class="waves-effect waves-dark"
                                    exact
                                    aria-expanded="false"
                                    v-if="showTeams"
                                    ><font-awesome-icon icon="users-cog" />
                                    <span class="hide-menu"
                                        >Teams</span
                                    ></router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/users"
                                    class="waves-effect waves-dark"
                                    aria-expanded="false"
                                    exact
                                    v-if="showUsers"
                                    ><font-awesome-icon icon="users" />
                                    <span class="hide-menu"
                                        >Users</span
                                    ></router-link
                                >
                            </li>
                            <li>
                                <a
                                    href="/auth/logout"
                                    class="waves-effect waves-dark"
                                    aria-expanded="false"
                                    > <font-awesome-icon icon="sign-out-alt"
                                /> <span class="hide-menu"
                                        >Logout</span
                                    >
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Body main content -->
            <router-view></router-view>
            <!-- Body main content -->
            <footer class="footer">
                <span class="d-flex justify-content-between">
                    <span>© 2020  | AT Technology™</span>
                    <span>Your are logged in as ❤ {{userType}}</span>
                </span>
                
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user', 'role', 'resources','permissions'],
    data() {
        return {
            userType: '',
            loggedInName: '',
            showDashboard: false,
            showResources: false,
            showTeams: false,
            showUsers: false,
            showRoles:false,
        }
    },
    created() {
        this.userType = this.role.name
        this.loggedInName = this.user.name
        _.map(this.resources, (item) => {

            if (item.slug === 'dashboard')
                this.showDashboard = true
            if (item.slug === 'resources')
                this.showResources = true
            if (item.slug === 'teams')
                this.showTeams = true
            if (item.slug === 'users')
                this.showUsers = true
            if(item.slug === 'roles')
                this.showRoles =true;
        })
        // calling setAdminPermission using commit function in store.js file
        this.$store.commit('setAdminPermission', this.permissions)
    },
}
</script>
<style scoped>
a.router-link-active {
    color: #fff;
    border-left: 3px solid #fff;
    background: #0f0f0f82;
}
li.router-link-active {
    color: #fff;
}
.sidebartoggler,
.nav-toggler {
    color: #2b2b2b !important;
}
.bars{
    color: #fff !important;
    font-size: 24px !important;
}
.user{
    font-size: 16px !important;
}
</style>

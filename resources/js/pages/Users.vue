<template>
    <div>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="lign-self-center">
                        <h4 class="text-themecolor">Users</h4>
                    </div>
                    <div class="align-self-center justify-content-end">
                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            v-if="isWritePermitted"
                        >
                            Add New User
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div
                                    class="table-responsive"
                                    v-if="
                                        users.data &&
                                        users.data.length > 0
                                    "
                                >
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>#ID</td>
                                                <td>Name</td>
                                                <td>Email</td>
                                                <td
                                                    v-if="
                                                        isUpdatePermitted ||
                                                        isDeletePermitted
                                                    "
                                                >
                                                    Action
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    item, index
                                                ) in users.data"
                                                :key="index"
                                            >
                                                <td>{{item.id}}</td>
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.email }}</td>
                                                <td
                                                    class="d-flex"
                                                    v-if="
                                                        isUpdatePermitted ||
                                                        isDeletePermitted
                                                    "
                                                >
                                                    <button
                                                        class="
                                                            btn btn-info btn-sm
                                                            mr-2
                                                        "
                                                        title="Edit"
                                                    >
                                                        <font-awesome-icon
                                                            icon="edit"
                                                        />
                                                    </button>
                                                    <button
                                                        class="
                                                            btn
                                                            btn-danger
                                                            btn-sm
                                                        "
                                                        title="Delete"
                                                    >
                                                        <font-awesome-icon
                                                            icon="trash-alt"
                                                        />
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            Total Entries : {{ totalUsers }}
                                        </div>
                                        <div>
                                            <span
                                                >Showing 1 to
                                                {{ usersPerPage }} of
                                                {{ totalUsers }}
                                                entries</span
                                            >
                                        </div>
                                        <div>
                                            <pagination
                                                style="float: right !important"
                                                :data="users"
                                                @pagination-change-page="
                                                    getUsers
                                                "
                                            ></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="jumbotron text-center w-100"
                                    v-if="
                                        users.data &&
                                        users.data.length === 0
                                    "
                                >
                                    <i class="far fa-surprise fa-4x"></i>
                                    <h5 class="display-5 my-3">
                                        No Data Found
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            users: {},
            currentPage: 0,
            lastPage: 0,
            totalUsers: 0,
            usersPerPage: 0,
        }
    },
    mounted() {
        this.getUsers()
    },
    methods: {
        async getUsers(page = 1) {
            const res = await this.callApi(
                'get',
                `users?page=${page}`
            )
            if (res.status == 200) {
                if (res.data) {
                    this.users = res.data
                    this.currentPage = res.data.current_page
                    this.lastPage = res.data.last_page
                    this.totalUsers = res.data.total
                    this.usersPerPage = res.data.data.length
                }
            } else this.error('Oops! Something went wrong')
        },
    },
    watch: {
    },
}
</script>

<template>
    <div>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $route.meta.title }}
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div
                            class="
                                d-flex
                                justify-content-end
                                align-items-center
                            "
                        >
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                v-if="isWritePermitted"
                                @click="openAddTeamModal()"
                            >
                                Add New Member
                            </button>
                            <button
                                class="btn text-white btn-sm m-l-15"
                                :class="
                                    showFilter ? 'btn-secondary' : 'btn-success'
                                "
                                @click="toggleFilters"
                                style="cursor: pointer"
                            >
                                <span v-if="!showFilter">Show </span>
                                <span v-else>Hide </span>
                                Filters
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="showFilter">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Filter by Name"
                                        v-model="filterName"
                                    />
                                </div>
                                <div
                                    class="
                                        col-lg-6 col-md-6 col-sm-6 col-12
                                        py-lg-0 py-md-0 py-1
                                    "
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Filter by Email"
                                        v-model="filterEmail"
                                    />
                                </div>
                            </div>
                            <div class="row d-flex mt-2">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Filter by Phone Number"
                                        v-model="filterPhone"
                                    />
                                </div>
                                <div
                                    class="
                                        col-lg-6 col-md-6 col-sm-6 col-12
                                        py-lg-0 py-md-0 py-1
                                    "
                                >
                                    <div class="form-group">
                                        <template>
                                            <multiselect
                                                v-model="filterRole"
                                                :options="allRoles"
                                                :multiple="true"
                                                :searchable="true"
                                                track-by="name"
                                                label="name"
                                                placeholder="Filter by Role"
                                            >
                                            </multiselect>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row d-flex justify-content-between">
                                    <span>
                                        <h5 class="card-title">
                                            Team Member Lists
                                        </h5>
                                    </span>
                                    <span>
                                        Total Entries :
                                        <span class="badge badge-dark">{{
                                            totalTeamMember
                                        }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-12">
                                    <div
                                        class="table-responsive"
                                        v-if="
                                            teams.data && teams.data.length > 0
                                        "
                                    >
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>#ID</td>
                                                    <td>Name</td>
                                                    <td>Email</td>
                                                    <td>Phone Number</td>
                                                    <td>Role</td>
                                                    <td>Status</td>
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
                                                    ) in teams.data"
                                                    :key="index"
                                                >
                                                    <td>{{ item.id }}</td>
                                                    <td>{{ item.name }}</td>
                                                    <td>{{ item.email }}</td>
                                                    <td>
                                                        {{ item.phone_number }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge"
                                                            :class="
                                                                item.roles[0]
                                                                    .slug ==
                                                                'admin'
                                                                    ? 'badge-purple'
                                                                    : item
                                                                          .roles[0]
                                                                          .slug ==
                                                                      'moderator'
                                                                    ? 'badge-info'
                                                                    : item
                                                                          .roles[0]
                                                                          .slug ==
                                                                      'sales_manager'
                                                                    ? 'badge-danger'
                                                                    : item
                                                                          .roles[0]
                                                                          .slug ==
                                                                      'product_manager'
                                                                    ? 'badge-violet'
                                                                    : item
                                                                          .roles[0]
                                                                          .slug ==
                                                                      'full_stack_developer'
                                                                    ? 'badge-warning'
                                                                    : item
                                                                          .roles[0]
                                                                          .slug ==
                                                                      'tech_lead'
                                                                    ? 'badge-orange'
                                                                    : 'badge-primary'
                                                            "
                                                            >{{
                                                                item.roles[0]
                                                                    .name
                                                            }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="
                                                                badge
                                                                badge-warning
                                                                text-white
                                                            "
                                                            v-if="
                                                                item.state == 0
                                                            "
                                                            >Inactive
                                                        </span>
                                                        <span
                                                            class="
                                                                badge
                                                                badge-success
                                                                text-white
                                                            "
                                                            v-if="
                                                                item.state == 1
                                                            "
                                                            >Active
                                                        </span>
                                                    </td>
                                                    <td
                                                        class="d-flex"
                                                        v-if="
                                                            isUpdatePermitted ||
                                                            isDeletePermitted ||
                                                            isManagePermission
                                                        "
                                                    >
                                                        <button
                                                            class="
                                                                btn
                                                                btn-info
                                                                btn-sm
                                                                mr-2
                                                            "
                                                            title="Edit"
                                                            @click="
                                                                openEditTeamModal(
                                                                    item
                                                                )
                                                            "
                                                            v-if="
                                                                isUpdatePermitted
                                                            "
                                                        >
                                                            <font-awesome-icon
                                                                icon="edit"
                                                            />
                                                        </button>

                                                        <button
                                                            class="
                                                                btn
                                                                btn-success
                                                                btn-sm
                                                                mr-2
                                                            "
                                                            @click="
                                                                viewPermissions(
                                                                    item
                                                                )
                                                            "
                                                            title="View Resources & Permissions"
                                                            v-if="
                                                                isManagePermission
                                                            "
                                                        >
                                                            <font-awesome-icon
                                                                icon="user-lock"
                                                            />
                                                        </button>
                                                        <button
                                                            class="
                                                                btn
                                                                btn-danger
                                                                btn-sm
                                                            "
                                                            @click="
                                                                deleteTeamMember(
                                                                    item.id
                                                                )
                                                            "
                                                            v-if="
                                                                isDeletePermitted
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
                                        <div
                                            class="
                                                d-flex
                                                justify-content-between
                                            "
                                        >
                                            <div>
                                                <span
                                                    >Showing 1 to
                                                    {{ teamMemberPerPage }} of
                                                    {{ totalTeamMember }}
                                                    entries</span
                                                >
                                            </div>
                                            <div>
                                                <pagination
                                                    style="
                                                        float: right !important;
                                                    "
                                                    :data="teams"
                                                    @pagination-change-page="
                                                        getTeams
                                                    "
                                                ></pagination>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="jumbotron text-center w-100"
                                        v-if="
                                            teams.data &&
                                            teams.data.length === 0
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
        <!-------  Modal --------->
        <div
            id="teamModal"
            class="modal fade"
            role="dialog"
            tabindex="-1"
            aria-hidden="true"
            data-backdrop="static"
            data-keyboard="false"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" @submit.prevent="submitForm()">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                {{
                                    addButton
                                        ? 'Add Team Member'
                                        : 'Edit Team Member'
                                }}
                            </h4>
                            <button
                                type="button"
                                class="close"
                                @click="closeModal()"
                            >
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row d-flex">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Name</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="name"
                                            placeholder="Name"
                                        />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Email</label
                                        >
                                        <input
                                            type="email"
                                            class="form-control"
                                            v-model="email"
                                            placeholder="Email"
                                        />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Phone Number</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="phone_number"
                                            placeholder="Phone Number"
                                        />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Select Role</label
                                        >
                                        <select
                                            class="form-control"
                                            v-model="selectedRole"
                                        >
                                            <option value="" disabled selected>
                                                --- Select Role ---
                                            </option>
                                            <option
                                                v-for="option in allRoles"
                                                :value="option.id"
                                                :key="option.id"
                                            >
                                                {{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="col-lg-6 col-md-6 col-12"
                                    v-if="addButton"
                                >
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Select Resources</label
                                        >
                                        <template>
                                            <multiselect
                                                v-model="selectedResources"
                                                :options="allResources"
                                                :multiple="true"
                                                :searchable="true"
                                                track-by="id"
                                                label="name"
                                                placeholder="Select Resources"
                                            >
                                            </multiselect>
                                        </template>
                                    </div>
                                </div>
                                <div
                                    class="col-lg-6 col-md-6 col-12"
                                    v-if="addButton"
                                >
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Select Permissions</label
                                        >
                                        <template>
                                            <multiselect
                                                v-model="selectedPermissions"
                                                :options="allPermissions"
                                                :multiple="true"
                                                :searchable="true"
                                                track-by="id"
                                                label="name"
                                                placeholder="Select Permissions"
                                            >
                                            </multiselect>
                                        </template>
                                    </div>
                                </div>
                                <div
                                    class="col-lg-6 col-md-6 col-12"
                                    v-if="editButton"
                                >
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Status</label
                                        >
                                        <select
                                            class="form-control"
                                            v-model="state"
                                        >
                                            <option
                                                v-for="status in statusOptions"
                                                :key="status.id"
                                                :value="status.value"
                                            >
                                                {{ status.text }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                v-if="addButton"
                                type="submit"
                                class="btn btn-primary btn-sm"
                                :disabled="isAdding"
                                :loading="isAdding"
                            >
                                {{
                                    isAdding ? 'Adding....' : 'Add Team Member'
                                }}
                            </button>
                            <button
                                v-if="editButton"
                                type="submit"
                                class="btn btn-primary btn-sm"
                                :disabled="isEditing"
                                :loading="isEditing"
                            >
                                {{
                                    isEditing
                                        ? 'Updating....'
                                        : 'Update Team Member'
                                }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div
            id="permissionModal"
            class="modal fade"
            role="dialog"
            tabindex="-1"
            aria-hidden="true"
            data-backdrop="static"
            data-keyboard="false"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" @submit.prevent="updatePermission()">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Edit Resources & Permissions
                            </h4>
                            <button
                                type="button"
                                class="close"
                                @click="closePermission()"
                            >
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Selected Resources</label
                                        >
                                        <template>
                                            <multiselect
                                                v-model="selectedResources"
                                                :options="allResources"
                                                :multiple="true"
                                                :searchable="true"
                                                track-by="id"
                                                label="name"
                                                placeholder="Select Resources"
                                            >
                                            </multiselect>
                                        </template>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Selected Permissions</label
                                        >
                                        <template>
                                            <multiselect
                                                v-model="selectedPermissions"
                                                :options="allPermissions"
                                                :multiple="true"
                                                :searchable="true"
                                                track-by="id"
                                                label="name"
                                                placeholder="Select Permissions"
                                            >
                                            </multiselect>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="submit"
                                class="btn btn-primary btn-sm"
                                :disabled="isEditing"
                                :loading="isEditing"
                            >
                                {{ isEditing ? 'Updating....' : 'Update' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import multiselect from 'vue-multiselect'
export default {
    components: { multiselect },
    data() {
        return {
            teams: {},
            currentPage: 0,
            lastPage: 0,
            totalTeamMember: 0,
            teamMemberPerPage: 0,
            name: '',
            email: '',
            phone_number: '',
            selectedRole: '',
            state: '',
            selectedPermissions: '',
            selectedResources: '',
            currentTeamMemberId: '',
            isAdding: false,
            isEditing: false,
            addButton: false,
            editButton: false,
            allRoles: [],
            statusOptions: [
                { text: 'Inactive', value: '0', id: 0 },
                { text: 'Active', value: '1', id: 1 },
            ],
            allResources: [],
            filterName: '',
            filterRole: '',
            filterEmail: '',
            filterPhone: '',
            allPermissions: [],
            showFilter: false,
        }
    },
    mounted() {
        this.getTeams()
        this.getRoles()
        this.getPermissions()
        this.getResources()
    },
    methods: {
        async getPermissions() {
            const res = await this.callApi('get', 'default/permissions')
            if (res.status === 200) {
                if (res.data) this.allPermissions = res.data
            } else this.error('Error in fetching all permisisons')
        },
        async getResources() {
            const res = await this.callApi('get', 'default/resources')
            if (res.status === 200) {
                if (res.data) this.allResources = res.data
            } else this.error('Error in fetching all resources')
        },
        async getRoles() {
            const res = await this.callApi('get', 'default/roles')
            if (res.status === 200) {
                if (res.data) this.allRoles = res.data
            } else this.error('Error in fetching all roles')
        },
        async getTeams(page = 1) {
            let selectedRole = _.pluck(this.filterRole, 'id')
            const res = await this.callApi(
                'get',
                `teams?page=${page}&name=${this.filterName}&role=${selectedRole}&phone=${this.filterPhone}&email=${this.filterEmail}`
            )
            if (res.status === 200) {
                this.teams = res.data
                this.currentPage = res.data.current_page
                this.lastPage = res.data.last_page
                this.totalTeamMember = res.data.total
                this.teamMemberPerPage = res.data.data.length
            } else this.error('Error in fetching all teams')
        },
        openAddTeamModal() {
            this.name = ''
            this.email = ''
            this.phone_number = ''
            this.selectedRole = ''
            this.selectedResources = ''
            this.selectedPermissions = ''
            this.currentTeamMemberId = ''
            this.addButton = true
            $('#teamModal').modal('show')
        },
        openEditTeamModal(item) {
            this.name = item.name ? item.name : ''
            this.email = item.email ? item.email : ''
            this.phone_number = item.phone_number ? item.phone_number : ''
            this.selectedRole = item.roles[0].id
            this.state = item.state ? item.state : 0
            this.currentTeamMemberId = item.id
            this.editButton = true
            $('#teamModal').modal('show')
        },
        closeModal() {
            this.addButton = false
            this.editButton = false
            $('#teamModal').modal('hide')
        },
        submitForm() {
            if (this.addButton) this.addTeam()
            if (this.editButton) this.editTeam()
        },
        async addTeam() {
            if (this.name.trim() === '')
                return this.warning('Name field is missing')

            if (this.email.trim() === '')
                return this.warning('Email field is missing')

            if (this.phone_number.trim() === '')
                return this.warning('Phone Number field is missing')

            if (this.selectedRole === '')
                return this.warning('Please select role')

            let selectedResources = _.pluck(this.selectedResources, 'id')

            if (selectedResources && selectedResources.length === 0)
                return this.warning('Please select resources')

            let selectedPermissions = _.pluck(this.selectedPermissions, 'id')

            if (selectedPermissions && selectedPermissions.length === 0)
                return this.warning('Please select permissions')
            let data = {
                name: this.name,
                email: this.email,
                phone_number: this.phone_number,
                role_id: this.selectedRole,
                resources: selectedResources,
                permissions: selectedPermissions,
            }
            data = JSON.parse(JSON.stringify(data))

            this.isAdding = true
            const res = await this.callApi('post', 'team', data)
            if (res.status === 201) {
                this.isAdding = false
                this.addButton = false
                this.getTeams(this.currentPage)
                $('#teamModal').modal('hide')
                this.success('Team member added successfully.')
            } else {
                this.isAdding = false
                if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.warning(res.data.errors[i][0])
                    }
                } else this.error('Oops! Something went wrong.')
            }
        },
        async editTeam() {
            if (this.name.trim() === '')
                return this.warning('Name field is missing')

            if (this.email.trim() === '')
                return this.warning('Email field is missing')

            if (this.phone_number.trim() === '')
                return this.warning('Phone Number field is missing')

            let data = {
                name: this.name,
                email: this.email,
                phone_number: this.phone_number,
                role_id: this.selectedRole,
                state: this.state,
            }
            data = JSON.parse(JSON.stringify(data))
            this.isEditing = true
            const res = await this.callApi(
                'put',
                `team/${this.currentTeamMemberId}`,
                data
            )
            if (res.status === 200) {
                this.isEditing = false
                this.editButton = false
                this.getTeams(this.currentPage)
                this.success('Resource updated successfully')
                $('#teamModal').modal('hide')
            } else {
                this.isEditing = false
                if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.warning(res.data.errors[i][0])
                    }
                } else this.error('Oops! Something went wrong.')
            }
        },
        deleteTeamMember(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/api/v1/team/${id}`)
                        .then((response) => {
                            if (response.status == 200) {
                                this.$nextTick(() => {
                                    this.success(
                                        'Team member deleted successfully'
                                    )
                                    this.getTeams(this.currentPage)
                                })
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                            this.error('Oops! Something went wrong.')
                        })
                }
            })
        },
        viewPermissions(team) {
            this.currentTeamMemberId = team.id
            this.selectedResources = team.resources ? team.resources : ''
            this.selectedPermissions = team.permissions ? team.permissions : ''
            $('#permissionModal').modal('show')
        },
        closePermission() {
            this.currentTeamMemberId = ''
            this.selectedResources = ''
            this.selectedPermissions = ''
            $('#permissionModal').modal('hide')
        },
        async updatePermission() {
            let selectedResources = _.pluck(this.selectedResources, 'id')

            if (selectedResources && selectedResources.length === 0)
                return this.warning('Please select resources')

            let selectedPermissions = _.pluck(this.selectedPermissions, 'id')

            if (selectedPermissions && selectedPermissions.length === 0)
                return this.warning('Please select permissions')
            let data = {
                resources: selectedResources,
                permissions: selectedPermissions,
            }
            data = JSON.parse(JSON.stringify(data))

            this.isEditing = true
            const res = await this.callApi(
                'put',
                `permission/resource/${this.currentTeamMemberId}`,
                data
            )
            if (res.status === 200) {
                this.isEditing = false
                this.currentTeamMemberId = ''
                this.selectedResources = ''
                this.selectedPermissions = ''
                this.getTeams(this.currentPage)
                this.success('Resources & Permissions updated successfully')
                $('#permissionModal').modal('hide')
            } else {
                this.isEditing = false
                if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.warning(res.data.errors[i][0])
                    }
                } else this.error('Oops! Something went wrong.')
            }
        },
        toggleFilters() {
            if (this.showFilter) this.showFilter = false
            else {
                this.showFilter = true
            }
        },
    },
    watch: {
        filterName: function (newValue, oldValue) {
            if (newValue !== oldValue) this.getTeams()
        },
        filterEmail: function (newValue, oldValue) {
            if (newValue !== oldValue) this.getTeams()
        },
        filterRole: function (newValue, oldValue) {
            if (newValue !== oldValue) this.getTeams()
        },
        filterPhone: function (newValue, oldValue) {
            if (newValue !== oldValue) this.getTeams()
        },
    },
}
</script>
<style scoped>
.badge-purple {
    color: #fff;
    background-color: #9700c2 !important;
}

a.badge-purple:focus,
a.badge-purple:hover {
    color: #fff;
    background-color: #9700c2 !important;
}

a.badge-purple.focus,
a.badge-purple:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 194, 146, 0.5);
}

.badge-orange {
    color: #fff;
    background-color: #d8b43e !important;
}

a.badge-orange:focus,
a.badge-orange:hover {
    color: #fff;
    background-color: #d8b43e !important;
}
.badge-violet {
    color: #fff;
    background-color: #eb20b8 !important;
}

a.badge-violet:focus,
a.badge-violet:hover {
    color: #fff;
    background-color: #eb20b8 !important;
}
</style>

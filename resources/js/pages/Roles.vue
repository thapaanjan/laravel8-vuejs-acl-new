<template>
    <div>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="lign-self-center">
                        <h4 class="text-themecolor">Roles</h4>
                    </div>
                    <div class="align-self-center justify-content-end">
                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            @click="openRolesModal()"
                            v-if="isWritePermitted"
                        >
                            Add New Role
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="
                                    row
                                    d-flex
                                    align-content-center
                                    justify-content-end
                                "
                            >
                                <div>
                                    <input
                                        type="text"
                                        v-model="filterName"
                                        class="form-control"
                                        placeholder="Filter by role name"
                                    />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div
                                    class="table-responsive"
                                    v-if="roles.data && roles.data.length > 0"
                                >
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>#ID</td>
                                                <td>Role Name</td>
                                                <td>Slug</td>
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
                                                ) in roles.data"
                                                :key="index"
                                            >
                                                <td>{{ item.id }}</td>
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.slug }}</td>
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
                                                        @click="
                                                            openEditResourceModal(
                                                                item
                                                            )
                                                        "
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
                                                        @click="
                                                            deleteResource(
                                                                item.id
                                                            )
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
                                            Total Entries : {{ totalRoles }}
                                        </div>
                                        <div>
                                            <span
                                                >Showing 1 to
                                                {{ rolesPerPage }} of
                                                {{ totalRoles }}
                                                entries</span
                                            >
                                        </div>
                                        <div>
                                            <pagination
                                                style="float: right !important"
                                                :data="roles"
                                                @pagination-change-page="
                                                    getRoles
                                                "
                                            ></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="jumbotron text-center w-100"
                                    v-if="roles.data && roles.data.length === 0"
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

        <!-------  Modal --------->
        <div
            id="roleModal"
            class="modal fade"
            role="dialog"
            tabindex="-1"
            aria-hidden="true"
            data-backdrop="static"
            data-keyboard="false"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" @submit.prevent="submitForm()">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                {{ addButton ? 'Add Role' : 'Edit Role' }}
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
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="name"
                                    placeholder="Name"
                                    @input="generateSlug($event)"
                                />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="description"
                                    placeholder="Description"
                                />
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
                                {{ isAdding ? 'Adding....' : 'Add Resource' }}
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
                                        : 'Update Resource'
                                }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            roles: {},
            currentPage: 0,
            lastPage: 0,
            totalRoles: 0,
            rolesPerPage: 0,
            name: '',
            slug: '',
            description: '',
            currentRoleId: '',
            isAdding: false,
            isEditing: false,
            addButton: false,
            editButton: false,
            filterName: '',
        }
    },
    mounted() {
        this.getRoles()
    },
    methods: {
        async getRoles(page = 1) {
            const res = await this.callApi(
                'get',
                `roles?page=${page}&name=${this.filterName}`
            )
            if (res.status == 200) {
                if (res.data) {
                    this.roles = res.data
                    this.currentPage = res.data.current_page
                    this.lastPage = res.data.last_page
                    this.totalRoles = res.data.total
                    this.rolesPerPage = res.data.data.length
                }
            } else this.error('Oops! Something went wrong')
        },
        generateSlug: function (event) {
            let text = event.target.value
            var slug = ''
            // Change to lower case
            var titleLower = text.toLowerCase()
            // Letter "e"
            slug = titleLower.replace(/e|é|e|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e')
            // Letter "a"
            slug = slug.replace(/a|á|à|a|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|a|ấ|ầ|ẫ|ẩ|ậ/gi, 'a')
            // Letter "o"
            slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o')
            // Letter "u"
            slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u')
            // Letter "d"
            slug = slug.replace(/đ/gi, 'd')
            // Trim the last whitespace
            slug = slug.replace(/\s*$/g, '')
            // Change whitespace to "-"
            slug = slug.replace(/\s+/g, '_')
            this.slug = slug
        },
        openRolesModal() {
            this.name = ''
            this.slug = ''
            this.description = ''
            this.currentRoleId = ''
            this.addButton = true
            $('#roleModal').modal('show')
        },
        openEditResourceModal(item) {
            this.currentRoleId = item.id
            this.name = item.name
            this.slug = item.slug
            this.description = item.description
            this.editButton = true
            $('#roleModal').modal('show')
        },
        closeModal() {
            this.addButton = false
            this.editButton = false
            $('#roleModal').modal('hide')
        },
        submitForm() {
            if (this.addButton) this.addResource()
            if (this.editButton) this.editResource()
        },
        async addResource() {
            if (this.name.trim() === '')
                return this.warning('Name field is missing')

            if (this.description.trim() === '')
                return this.warning('Description field is missing')

            let data = {
                name: this.name,
                slug: this.slug,
                description: this.description,
            }
            data = JSON.parse(JSON.stringify(data))
            this.isAdding = true
            const res = await this.callApi('post', `role`, data)
            if (res.status === 201) {
                this.isAdding = false
                this.addButton = false
                this.getRoles(this.currentPage)
                this.success('Role added successfully')
                $('#roleModal').modal('hide')
            } else {
                this.isAdding = false
                if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.warning(res.data.errors[i][0])
                    }
                } else this.error('Oops! Something went wrong.')
            }
        },
        async editResource() {
            if (this.name.trim() === '')
                return this.warning('Name field is missing')

            if (this.description.trim() === '')
                return this.warning('Description field is missing')

            let data = {
                name: this.name,
                slug: this.slug,
                description: this.description,
            }
            data = JSON.parse(JSON.stringify(data))
            this.isEditing = true
            const res = await this.callApi(
                'put',
                `role/${this.currentRoleId}`,
                data
            )
            if (res.status === 200) {
                this.isEditing = false
                this.editButton = false
                this.getRoles(this.currentPage)
                this.success('Role updated successfully')
                $('#roleModal').modal('hide')
            } else {
                this.isEditing = false
                if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.warning(res.data.errors[i][0])
                    }
                } else this.error('Oops! Something went wrong.')
            }
        },
        async deleteResource(id) {
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
                        .delete(`/api/v1/role/${id}`)
                        .then((response) => {
                            if (response.status == 200) {
                                this.$nextTick(() => {
                                    this.success('Role deleted successfully')
                                    this.getRoles(this.currentPage)
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
    },
    watch: {
        filterName: function (newValue, oldValue) {
            if (newValue !== oldValue) this.getRoles()
        },
    },
}
</script>

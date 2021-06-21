<template>
    <div>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="lign-self-center">
                        <h4 class="text-themecolor">Resources</h4>
                    </div>
                    <div class="align-self-center justify-content-end">
                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            @click="openAddResourceModal()"
                            v-if="isWritePermitted"
                        >
                            Add New Resource
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
                                        placeholder="Filter by resource name"
                                    />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div
                                    class="table-responsive"
                                    v-if="
                                        resources.data &&
                                        resources.data.length > 0
                                    "
                                >
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>#ID</td>
                                                <td>Resource Name</td>
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
                                                ) in resources.data"
                                                :key="index"
                                            >
                                                <td>{{item.id}}</td>
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
                                            Total Entries : {{ totalResources }}
                                        </div>
                                        <div>
                                            <span
                                                >Showing 1 to
                                                {{ resourcesPerPage }} of
                                                {{ totalResources }}
                                                entries</span
                                            >
                                        </div>
                                        <div>
                                            <pagination
                                                style="float: right !important"
                                                :data="resources"
                                                @pagination-change-page="
                                                    getResources
                                                "
                                            ></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="jumbotron text-center w-100"
                                    v-if="
                                        resources.data &&
                                        resources.data.length === 0
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

        <!-------  Modal --------->
        <div
            id="resourceModal"
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
                                {{
                                    addButton ? 'Add Resource' : 'Edit Resource'
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
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="name"
                                    @input="generateSlug($event)"
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
            resources: {},
            currentPage: 0,
            lastPage: 0,
            totalResources: 0,
            resourcesPerPage: 0,
            name: '',
            slug: '',
            currentResourceId: '',
            isAdding: false,
            isEditing: false,
            addButton: false,
            editButton: false,
            filterName: '',
        }
    },
    mounted() {
        this.getResources()
    },
    methods: {
        async getResources(page = 1) {
            const res = await this.callApi(
                'get',
                `resources?page=${page}&name=${this.filterName}`
            )
            if (res.status == 200) {
                if (res.data) {
                    this.resources = res.data
                    this.currentPage = res.data.current_page
                    this.lastPage = res.data.last_page
                    this.totalResources = res.data.total
                    this.resourcesPerPage = res.data.data.length
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
        openAddResourceModal() {
            this.name = ''
            this.slug = ''
            this.currentResourceId = ''
            this.addButton = true
            $('#resourceModal').modal('show')
        },
        openEditResourceModal(item) {
            this.currentResourceId = item.id
            this.name = item.name
            this.slug = item.slug
            this.editButton = true
            $('#resourceModal').modal('show')
        },
        closeModal() {
            this.addButton = false
            this.editButton = false
            $('#resourceModal').modal('hide')
        },
        submitForm() {
            if (this.addButton) this.addResource()
            if (this.editButton) this.editResource()
        },
        async addResource() {
            if (this.name.trim() === '')
                return this.warning('Name field is missing')

            let data = {
                name: this.name,
                slug: this.slug,
            }
            data = JSON.parse(JSON.stringify(data))
            this.isAdding = true
            const res = await this.callApi('post', `resource`, data)
            if (res.status === 201) {
                this.isAdding = false
                this.addButton = false
                this.getResources(this.currentPage)
                this.success('Resource added successfully')
                $('#resourceModal').modal('hide')
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

            let data = {
                name: this.name,
                slug: this.slug,
            }
            data = JSON.parse(JSON.stringify(data))
            this.isEditing = true
            const res = await this.callApi(
                'put',
                `resource/${this.currentResourceId}`,
                data
            )
            if (res.status === 200) {
                this.isEditing = false
                this.editButton = false
                this.getResources(this.currentPage)
                this.success('Resource updated successfully')
                $('#resourceModal').modal('hide')
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
                        .delete(`/api/v1/resource/${id}`)
                        .then((response) => {
                            if (response.status == 200) {
                                this.$nextTick(() => {
                                    this.success(
                                        'Resource deleted successfully'
                                    )
                                    this.getResources(this.currentPage)
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
            if (newValue !== oldValue) this.getResources()
        },
    },
}
</script>

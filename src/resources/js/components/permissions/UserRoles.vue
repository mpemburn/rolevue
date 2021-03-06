<template>
    <div class="">

        <div v-if="errorMessage && ! showModal" class="m-2 text-danger">{{ errorMessage }}</div>

        <table id="user-roles-table" class="stripe">
            <thead>
            <tr>
                <th v-for="header in headers" :class="header.class">{{ header.text }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <ul v-for="role in user.roles">
                        <li>{{ role.name }}</li>
                    </ul>
                </td>
                <td>
                    <ul v-for="permission in user.permissions">
                        <li>{{ permission.name }}</li>
                    </ul>
                </td>
                <td>
                    <component :is="editButton" v-bind="{ editId: user.id }"
                               @messageFromEditButton="editButtonMessageRecieved">Edit
                    </component>
                </td>
            </tr>
            </tbody>
        </table>
        <section>
            <vue-tailwind-modal
                :showing="showModal"
                @close="showModal = false"
                :showClose="true"
                :backgroundClose="true"
            >
                <div class="mb-1 text-xl font-bold">
                    Edit Roles for {{ user.name }}
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group font-bold overflow-scroll">
                        Roles:
                        <div class="border-solid border-gray-300 border-2 overflow-scroll">
                            <ul class="p-4">
                                <li v-for="role in user.roles">
                                    <input
                                        type="checkbox"
                                        name="role[]"
                                        v-model="role.checked"
                                        :value="role.id"
                                    >
                                    {{ role.name }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group font-bold overflow-scroll">
                        Permissions:
                        <div class="border-solid border-gray-300 border-2 overflow-scroll">
                            <ul class="p-4">
                                <li v-for="permission in user.permissions">
                                    <input
                                        type="checkbox"
                                        name="permission[]"
                                        v-model="permission.checked"
                                        :value="permission.id"
                                    > {{ permission.name }}
                                </li>
                                <li v-for="assigned in user.assignedPermissions" class="text-muted">
                                    <input type="checkbox" style="opacity: 0.5;" checked disabled> {{ assigned.name }}
                                </li>
                            </ul>
                        </div>
                        <div v-if="hasAssignedPermissions">
                            NOTE: Grayed permissions are assigned to one or more of this user's Roles.
                        </div>
                    </div>
                </div>
                <footer class="flex justify-end px-0 pb-0 pt-4">
                    <div v-if="errorMessage" class="text-danger">{{ errorMessage }}</div>
                    <button @click="showModal = false"
                            class="modal-close ml-3 rounded mx-1 px-3 py-1 bg-gray-300 hover:bg-gray-200 focus:shadow-outline focus:outline-none">
                        Cancel
                    </button>
                    <button @click="saveUser"
                            class="rounded px-3 py-1 bg-blue-700 hover:bg-blue-500 disabled:opacity-50 text-white focus:shadow-outline focus:outline-none">
                        Save
                    </button>
                </footer>
            </vue-tailwind-modal>
        </section>
    </div>
</template>

<style scoped></style>
<script>
import axios from "axios";
import EditButton from '../buttons/EditButton.vue';

export default {
    name: "UserRoles",
    data() {
        return {
            showModal: false,
            showConfirm: false,
            modalContext: null,
            modalTitle: null,
            confirmMessage: null,
            errorMessage: null,
            userId: null,
            currentRoleId: null,
            hasAssignedPermissions: false,
            user: {
                name: null,
                roles: [],
                permissions: []
            },
            users: [],
            permissions: [],
            headers: [
                {text: "User", class: "w-3/12"},
                {text: "Email", class: "w-4/12"},
                {text: "Roles", class: "w-2/12"},
                {text: "Permissions", class: "w-2/12"},
                {text: "", class: "w-1/12"},
            ],
            editButton: 'EditButton',
            modal: 'Modal',
        };
    },
    watch: {
        users(val) {
            this.refreshTable();
        }
    },
    methods: {
        readUsersFromAPI() {
            this.users = [];
            axios
                .get("/api/user_roles")
                .then((response) => {
                    if (response.data.users === null) {
                        return;
                    }
                    response.data.users.forEach(user => {
                        this.users.push({
                            'id': user.id,
                            'name': user.name,
                            'roles': user.roles,
                            'permissions': user.permissions
                        });
                    });
                });
        },
        editButtonMessageRecieved(userId) {
            this.userId = userId;
            this.userName = null;
            axios.get('/api/user_roles/' + userId)
                .then(response => {
                    if (! response.data.user) {
                        return;
                    }
                    console.log(response.data);
                    let user = response.data.user;
                    let diff = response.data.diff;
                    this.user = {
                        id: user.id,
                        name: user.name,
                        roles: this.populateCheckboxes(user.roles, diff.roles),
                        permissions: this.populateCheckboxes(user.permissions, diff.permissions),
                        assignedPermissions: response.data.assigned_permissions
                    }
                    this.hasAssignedPermissions = this.user.assignedPermissions.length > 0;
                    this.showModal = true;
                }).catch(error => {
                    this.showError(error);
            });
        },
        populateCheckboxes(userRoles, diffRoles) {
            let roles = this.hydrate(userRoles, true);
            let diff = this.hydrate(diffRoles, false);

            return roles.concat(diff);
        },
        saveUser() {
            axios.post('/api/user_roles', {
                id: this.userId,
                roles: this.user.roles,
                permissions: this.user.permissions
            }).then(response => {
                if (response.data.success) {
                    this.showModal = false;
                    this.readUsersFromAPI();
                }
            }).catch(error => {
                this.showError(error);
            });
        },
        getRoleById(userId) {
            let found = null;

            this.users.forEach(user => {
                if (user.id === userId) {
                    found = user;
                }
            });

            return found;
        },
        initDataTable() {
            this.dataTable = $('#user-roles-table').DataTable({
                pageLength: 100,
                lengthMenu: [10, 25, 50, 75, 100],
                columnDefs: [
                    {
                        orderable: false,
                        targets: [1, 2]
                    }
                ]
            });
        },
        refreshTable() {
            if (this.dataTable !== undefined) {
                this.dataTable.destroy();
                this.$nextTick(() => {
                    this.initDataTable();
                })
            }
        }
    },
    components: {
        EditButton,
    },
    updated() {
        if (this.dataTable === undefined) {
            this.initDataTable();
        }
    },
    mounted() {
        this.readUsersFromAPI();
    },
};

</script>

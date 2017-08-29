<template>
    <div>
        <box>
            <box-title>
                Users
                <box-tools slot="tools">
                    <box-tool icon="plus" @click.native="add">New</box-tool>
                </box-tools>
            </box-title>
            <box-content>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="( user, index ) in users">
                            <td>{{ index + 1 }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role.name }}</td>
                            <td>
                                <toggle-button
                                        :value="user.status"
                                        :sync="true"
                                        @change="updateStatus($event.value, user)"
                                        :disabled="canUpdateStatus(user)"
                                />
                            </td>
                            <td>
                                <btn-success
                                        size="xs"
                                        @click.native="edit(user)"
                                >
                                    <icon icon="edit"/>
                                </btn-success>

                                <btn-danger
                                        @click.native="destroy(user)"
                                        :disabled="user.destroyForm.busy"
                                        v-if="canDestroy(user)"
                                        size="xs"
                                >
                                    <spinner v-if="user.destroyForm.busy"></spinner>
                                    <icon icon="trash" v-else/>
                                </btn-danger>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </box-content>
        </box>
        <user-form ref="form" @saved="formSaved"></user-form>
    </div>
</template>

<script>
    import UserForm from './user-form';

    export default {
        components: {
            UserForm
        },
        data() {
            return {
                users: []
            }
        },

        mounted() {
            this.reload();
        },

        methods: {
            canUpdateStatus(user) {
                return Slc.user.id === user.id;
            },
            canDestroy(user) {
                return Slc.user.id !== user.id;
            },

            add() {
                this.$refs.form.show();
            },

            edit(user) {
                this.$refs.form.show(user);
            },

            reload() {
                let self = this;
                Slc.get(laroute.route('api.user.index'))
                    .then((response) => {
                        self.users = response;
                    });
            },

            formSaved(user) {
                let index = this.findIndex(user);
                index > -1 ? this.users[index] = user : this.users.push(user);
            },

            destroy(user) {
                let self = this;
                Slc.delete(laroute.route('api.user.destroy', {user: user.id}), user.destroyForm)
                    .then(() => {
                        self.removeUser(user);
                    });
            },

            updateStatus(value, item) {
                item.status = value;
                let form = new SlcForm(item);
                this.$refs.form.update(form);
            },

            removeUser(user) {
                this.users.splice(this.findIndex(user), 1);
            },

            findIndex(user) {
                return this.users.findIndex((_user) => {
                    return _user.id === user.id;
                });
            }
        }
    }
</script>
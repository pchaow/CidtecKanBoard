<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Create User
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="save">
                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['email'] }">
                                <label class="control-label">E-mail : </label>
                                <input class="form-control" placeholder="E-mail" v-model="formInputs.email"/>
                                <span v-if="formErrors['email']" class="help-block">{{ formErrors['email'] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['firstname'] }">
                                <label class="control-label">First Name : </label>
                                <input class="form-control" placeholder="First Name" v-model="formInputs.firstname"/>
                                <span v-if="formErrors['firstname']"
                                      class="help-block">{{ formErrors['firstname'] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['lastname'] }">
                                <label class="control-label">Last Name : </label>
                                <input class="form-control" placeholder="Last Name" v-model="formInputs.lastname"/>
                                <span v-if="formErrors['lastname']"
                                      class="help-block">{{ formErrors['lastname'] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['password'] }">
                                <label class="control-label">Password : </label>
                                <input type="password" class="form-control" placeholder="Password" v-model="formInputs.password"/>
                                <span v-if="formErrors['password']"
                                      class="help-block">{{ formErrors['password'] }}</span>
                            </div>

                            <div class="form-group"
                                 v-bind:class="{ 'has-error': formErrors['password_confirmation '] }">
                                <label class="control-label">Password Confirmation : </label>
                                <input type="password" class="form-control" placeholder="Password Confirmation"
                                       v-model="formInputs.password_confirmation "/>
                                <span v-if="formErrors['password_confirmation ']" class="help-block">{{ formErrors['password_confirmation '] }}</span>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Roles : </label>
                                <div class="checkbox" v-for="role in roles">
                                    <label>
                                        <input type="checkbox" v-model="formInputs.roles"  v-bind:value="role">
                                        {{role.name}}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="/backend/admin/user" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
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
                roles: [],
                formInputs: {
                    roles: [],
                },
                formErrors: [],
            }
        },
        methods: {
            save: function () {
                console.log(this.formInputs);
                this.formErrors = []
                this.$http.post('/api/v1/admin/user', this.formInputs)
                        .then((response) => {
                                    // success callback
                                    console.log(response);
                                    window.location.href = '/backend/admin/user'
                                }, (response) => {
                                    // error callback
                                    this.formErrors = response.data;
                                }
                        );
            },
            loadRoles: function () {
                this.$http.get('/api/v1/admin/role', {
                    params: {all: true}
                }).then(function (r) {
                    console.log(r.data)
                    this.rolesPage = r.data
                    this.roles = this.rolesPage.data

                })
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.loadRoles();
        }
    }
</script>

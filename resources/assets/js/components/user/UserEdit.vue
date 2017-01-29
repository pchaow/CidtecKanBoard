<template>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    Edit User
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="save">
                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['email'] }">
                                <label class="control-label">E-mail : </label>
                                <input type="text" readonly class="form-control" placeholder="E-mail"
                                       v-model="formInputs.email"/>
                                <span v-if="formErrors['email']" class="help-block">{{ formErrors['email'] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['username'] }">
                                <label class="control-label">Username : </label>
                                <input type="text" readonly class="form-control" placeholder="Username"
                                       v-model="formInputs.username"/>
                                <span v-if="formErrors['username']"
                                      class="help-block">{{ formErrors['username'] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                                <label class="control-label">Name : </label>
                                <input class="form-control" placeholder="Name" v-model="formInputs.name"/>
                                <span v-if="formErrors['name']"
                                      class="help-block">{{ formErrors['name'] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['password'] }">
                                <label class="control-label">Password : </label>
                                <input type="password" class="form-control" placeholder="Password"
                                       v-model="formInputs.password"/>
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
                                        <input type="checkbox" v-model="formInputs.roles" v-bind:value="role">
                                        {{role.name}}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a v-bind:href="successUrl" class="btn btn-default">Cancel</a>
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
        props: {
            userId: Number,
            saveUrl : String,
            loadUrl : String,
            successUrl : String,
            loadRolesUrl : String,
        },
        data() {
            return {
                roles: [],
                formInputs: {},
                formErrors: [],
            }
        },
        methods: {
            save: function () {
                this.formErrors = [];
                this.$http.put(this.saveUrl, this.formInputs)
                        .then((response) => {
                            // success callback
                            // console.log(response);
                            window.location.href = this.successUrl
                        }, (response) => {
                            // error callback
                            this.formErrors = response.data;
                        });


            },
            load: function () {

                this.$http.get(this.loadUrl)
                        .then((response) => {
                            // success callback
                            // console.log(response);
                            this.formInputs = response.data;
                            this.reInitialMultiOption(this.roles,this.formInputs.roles);

                        }, (response) => {
                            // error callback
                            this.formErrors = response.data;
                        })
            },
            loadRoles: function () {
                return this.$http.get(this.loadRolesUrl, {
                    params: {all: true}
                }).then(function (r) {
                    console.log(r.data)
                    this.rolesPage = r.data
                    this.roles = this.rolesPage.data

                })
            },
            reInitialMultiOption: function (master,selected) {

                var choiceOpt = master
                var userOpt = selected

                for (var i = 0; i < choiceOpt.length; i++) {
                    //console.log("choice", choiceOpt[i].id, choiceOpt[i].choice)

                    for (var j = 0; j < userOpt.length; j++) {

                        //console.log("user", userOpt[j])
                        if (choiceOpt[i].id == userOpt[j].id) {
                            choiceOpt.splice(i, 1, userOpt[j]);
                            break;
                        }
                    }
                }
            }
        },
        created(){
            this.loadRoles()
        },
        mounted() {
            console.log('ready to edit user.id =', this.userId)
            this.load()
        }
    }















</script>

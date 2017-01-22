<template>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    Create Role
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="save">

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                                <label class="control-label">Name : </label>
                                <input class="form-control" placeholder="Name" v-model="formInputs.name"/>
                                <span v-if="formErrors['name']" class="help-block">{{ formErrors['name'] }}</span>

                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['display_name'] }">
                                <label class="control-label">Display Name : </label>
                                <input class="form-control" placeholder="Display Name"
                                       v-model="formInputs.display_name"/>
                                <span v-if="formErrors['display_name']" class="help-block">{{ formErrors['display_name'] }}</span>

                            </div>


                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['description'] }">
                                <label class="control-label">Description : </label>
                                <input class="form-control" placeholder="Description" v-model="formInputs.description"/>
                                <span v-if="formErrors['description']" class="help-block">{{ formErrors['description'] }}</span>
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
            successUrl : String,
            saveRoleUrl : String,
        },
        data() {
            return {
                formInputs: {},
                formErrors: [],
            }
        },
        methods: {
            save: function () {
                this.formErrors = [];
                this.$http.post(this.saveRoleUrl, this.formInputs)
                        .then((response) => {
                            // success callback
                            window.location.href = this.successUrl

                        }, (response) => {
                            // error callback
                            this.formErrors = response.data;
                        });

            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }

</script>

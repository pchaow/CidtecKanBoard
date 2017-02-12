<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    New Board
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="save">
                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                                <label class="control-label">Name : </label>
                                <input type="text" class="form-control" placeholder="Name" v-model="formInputs.name"/>
                                <span v-if="formErrors['name']" class="help-block">{{ formErrors['name'] }}</span>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['description'] }">
                                <label class="control-label">Description : </label>
                                <textarea rows="5" class="form-control" placeholder="Description"
                                          v-model="formInputs.description"></textarea>
                                <span v-if="formErrors['description']"
                                      class="help-block">{{ formErrors['description'] }}</span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a :href="'/'+user.username" class="btn btn-default">Cancel</a>
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
            saveUrl: String,
            user: Object,
        },

        data() {
            return {
                formInputs: {},
                formErrors: [],
            }
        },
        methods: {
            save: function () {
                console.log(this.formInputs);
                this.formErrors = []
                this.$http.post(this.saveUrl, this.formInputs)
                    .then((response) => {
                            // success callback
                            //console.log(response);
                            window.location.href = '/home'
                        }, (response) => {
                            // error callback
                            this.formErrors = response.data;
                        }
                    );
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

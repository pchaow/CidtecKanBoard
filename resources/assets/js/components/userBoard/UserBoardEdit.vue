<template>
    <div class="row" v-if="board">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Board Information
                </div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="save">
                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                                <label class="control-label">Name : </label>
                                <input readonly type="text" class="form-control" placeholder="Name"
                                       v-model="formInputs.name"/>
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
                                <a href="./" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Board's Lane
                    <div class="btn-group btn-group-sm pull-right">
                        <button v-on:click="addLane" class="btn btn-default">Add Lane</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="updateLanes">
                            <div v-for="(lane,index) in board.lanes" class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Name" v-model="lane.name"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger" v-on:click="deleteLane(lane,index)"
                                                type="button">Delete</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="./" class="btn btn-default">Cancel</a>
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
            loadUrl: String,
            successUrl: String,
            deleteLaneUrl: String,
            user: Object,
        },
        data() {
            return {
                formInputs: {},
                formErrors: [],
                board: {},
            }
        },
        methods: {
            strFormat: window.strFormat,

            deleteLane: function (lane, index) {
                if (lane.id) {
                    this.$http.delete(this.strFormat(this.deleteLaneUrl,{id:lane.id}), this.formInputs)
                        .then((response) => {
                            this.board.lanes.splice(index, 1)
                        }, (response) => {

                        });
                } else {
                    this.board.lanes.splice(index, 1)
                }
            },
            addLane: function () {
                this.board.lanes.push({})
            },
            updateLanes: function () {
                this.formErrors = [];
                this.$http.put(this.saveUrl, this.formInputs)
                    .then((response) => {
                        //window.location.href = this.successUrl

                    }, (response) => {
                        this.formErrors = response.data;
                        //console.log(this.formErrors);
                    });
            },
            save: function () {
                this.formErrors = [];
                this.$http.put(this.saveUrl, this.formInputs)
                    .then((response) => {
                        //window.location.href = this.successUrl
                        console.log(response);
                        window.location.href = this.successUrl
                    }, (response) => {
                        this.formErrors = response.data;
                        //console.log(this.formErrors);
                    });
            },
            load: function () {
                this.$http.get(this.loadUrl)
                    .then((response) => {
                        // success callback
                        this.board = response.data;
                        this.formInputs = response.data;
                        console.log(this.board)

                    }, (response) => {
                        // error callback
                        this.formErrors = response.data;
                        console.log(this.formErrors)
                    });
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.load()
        }
    }
</script>

<template>
    <div class="row" v-if="board">
        <div class="col-md-12">
            <h3>แก้ไขกระดาน : {{board.name}}</h3>
            <hr/>
            <form class="form-horizontal" v-on:submit.prevent="save">

                <div class="form-group col-md-12" v-bind:class="{ 'has-error': formErrors['name'] }">
                    <label class="control-label">Name : </label>
                    <input readonly type="text" class="form-control" placeholder="Name"
                           v-model="formInputs.name"/>
                    <span v-if="formErrors['name']" class="help-block">{{ formErrors['name'] }}</span>
                </div>

                <div class="form-group col-md-12" v-bind:class="{ 'has-error': formErrors['description'] }">
                    <label class="control-label">Description : </label>
                    <textarea rows="5" class="form-control" placeholder="Description"
                              v-model="formInputs.description"></textarea>
                    <span v-if="formErrors['description']" class="help-block">{{ formErrors['description']
                        }}</span>
                </div>

                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="./" class="btn btn-default">Cancel</a>
                </div>
            </form>

        </div>

        <div class="col-md-12">
            <hr/>
            <h3>ปิดกระดาน : {{board.name}}</h3>
            <span>หากปิดกระดานไปแล้ว การที่จะเปิดกระดานใหม่อีกครั้งต้องติดต่อผู้ดูแลระบบ กรุณาใช้ความระมัดระวัง</span>


            <form class="form-horizontal" v-on:submit.prevent="close">

                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-danger">Close Project</button>
                </div>
            </form>

        </div>
    </div>
</template>

<script type="application/javascript">
    import '!style!css!../../../css/autocomplete.css';

    export default {
        props: {
            saveUrl: String,
            loadUrl: String,
            successUrl: String,
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
            close: function () {
                this.$http.delete(this.saveUrl)
                    .then(function (response) {

                    }, function (error) {

                    })
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

<style type="text/css">

</style>

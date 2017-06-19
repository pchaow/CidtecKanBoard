<template>
    <div class="row" v-if="board">
        <div class="col-md-12">
            <h3>แก้ไขช่วง Sprint : {{board.name}}</h3>
            <hr/>
            <form class="form-horizontal" v-on:submit.prevent="save">



                <div class="form-group col-md-12" v-bind:class="{ 'has-error': formErrors['description'] }">
                    <label class="control-label">ระยะเวลา(วัน) : </label>
                    <input type="number" class="form-control" placeholder="ระยะเวลา(วัน)"
                              v-model="formInputs.sprint"></input>
                    <span v-if="formErrors['sprint']" class="help-block">{{ formErrors['sprint']
                        }}</span>
                </div>

                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="./" class="btn btn-default">Cancel</a>
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

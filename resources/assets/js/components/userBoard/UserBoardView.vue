<template>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                {{board.name}}
                <div class="btn-group btn-group-sm pull-right">
                    <a v-bind:href="board.name+'/edit'" class="btn btn-default">Edit</a>
                </div>
              </div>
                <div class="panel-body">
                    <div class="col-lg-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        editUrl : String,
        loadUrl: String,
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
        load: function() {
            this.$http.get(this.loadUrl)
                .then((response) => {
                    // success callback
                    this.board = response.data;
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

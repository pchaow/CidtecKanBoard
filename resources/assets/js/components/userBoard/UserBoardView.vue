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
            user: Object,
            board: Object,
        },
        data() {
            return {
            }
        },
        methods: {

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

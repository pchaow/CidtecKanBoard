<template>
    <div class="row" v-if="board">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    {{board.name}}
                    <div class="btn-group btn-group-sm pull-right">
                        <a class="btn btn-default">Edit</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div v-for="lane in board.lanes" class="col-md-3">
                            <div class="panel panel-success lane">
                                <div class="panel-heading">{{lane.name}}</div>
                                <div class="panel-body">
                                    lane board cards
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style type="text/css">
    .lane {
        min-height: 500px;
    }

    .row-fluid {
        white-space: nowrap;
        overflow-x: scroll;
        overflow-y : auto;
    }

    .row-fluid .col-md-3 {
        display: inline-block;
        float: none;
    }

</style>

<script type="application/javascript">
    export default {
        props: {
            user: Object,
            boardId: [Number, String],
            loadBoardUrl: String,
        },
        data() {
            return {
                board: null,
            }
        },
        methods: {
            strFormat: window.strFormat,
            loadBoard: function () {
                this.$http.get(this.loadBoardUrl).then(function (response) {
                    this.board = response.data
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.loadBoard();
        }
    }
</script>

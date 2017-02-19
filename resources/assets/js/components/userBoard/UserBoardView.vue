<template>
<div class="row" v-if="board">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                {{board.name}}
                <div class="btn-group btn-group-sm pull-right">
                    <a :href="strFormat('/{user}/{board}/edit',{user : user.username, board:board.name})"
                       class="btn btn-default">Edit</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div v-for="lane in board.lanes" class="col-md-3">
                        <div class="panel panel-success lane">
                            <div class="panel-heading">{{lane.name}}</div>
                            <div class="panel-body">
                                <div class="wrapper">
                                    <div class="card" v-dragula="card" bag="first-bag">
                                        <div v-for="card in lane.cards">{{card.name}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <form class="form-inline" v-on:submit.prevent="saveLane">
                            <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                                <input type="text" class="form-control" placeholder="add new lane.." v-model="formInputs.name" required/>
                                <span v-if="formErrors['name']" class="help-block">{{ formErrors['name'] }}</span>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
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
    overflow-y: auto;
}

.row-fluid .col-md-3 {
    display: inline-block;
    float: none;
}

.wrapper {
    display: table;
    width: 100%;
    min-height: 100%;
}

.card {
    display: table-cell;
    padding: 10px;
    background-color: #e2e4e6;
}

.card:nth-child(odd) {
    background-color: #e2e4e6;
}

.card div,
.gu-mirror {
    padding: 10px;
    background-color: #ffffff;
    transition: opacity 0.4s ease-in-out;
}

.card div {
    white-space: pre-line;
    cursor: move;
    cursor: grab;
    cursor: -moz-grab;
    cursor: -webkit-grab;
    margin-bottom: 10px;
}

.card div:last-child {
    margin-bottom: 0;
}

.gu-mirror {
    cursor: grabbing;
    cursor: -moz-grabbing;
    cursor: -webkit-grabbing;
}

.handle {
    padding: 0 5px;
    margin-right: 5px;
    background-color: rgba(0, 0, 0, 0.4);
    cursor: move;
}
</style>

<script type="application/javascript">
export default {
    props: {
        user: Object,
        boardId: [Number, String],
        loadBoardUrl: String,
        saveLaneUrl: String,
    },
    data() {
        return {
            board: null,
            formInputs: {},
            formErrors: [],
        }
    },
    methods: {
        strFormat: window.strFormat,
        loadBoard: function() {
            this.$http.get(this.loadBoardUrl).then(function(response) {
                this.board = response.data
            })
        },
        saveLane: function() {
            this.formErrors = []
            this.$http.post(this.saveLaneUrl, this.formInputs)
                .then((response) => {
                    this.loadBoard();
                }, (response) => {
                    this.formErrors = response.data;
                });
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.loadBoard();
    }
}
</script>

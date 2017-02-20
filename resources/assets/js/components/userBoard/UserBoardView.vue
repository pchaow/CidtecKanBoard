<template>
<div class="row" v-if="board">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                {{board.name}}
                <div class="btn-group btn-group-sm pull-right">
                    <a :href="strFormat('/{user}/{board}/edit',{user : user.username, board:board.name})" class="btn btn-default">Edit</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div v-for="lane in board.lanes" class="col-md-3">
                        <div class="panel panel-success lane">
                            <div class="panel-heading">
                                {{lane.name}}
                                <div class="pull-right">
                                    <el-dropdown trigger="click" @command="handleCommand">
                                        <span class="el-dropdown-link">
                                       <i class="el-icon-caret-bottom el-icon--right"></i>
                                    </span>
                                        <el-dropdown-menu slot="dropdown">
                                            <el-dropdown-item :command="lane.id+'addCard'">Add Card</el-dropdown-item>
                                            <el-dropdown-item>Edit</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="wrapper">
                                    <div class="card" v-dragula="Lane" drake="events" service="events" :idLane="lane.id">
                                        <div v-for="card in lane.cards" :idCard="card.id">{{card.name}}</div>
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
    <!--  Dialog Form New Card-->
    <user-Board-form-card v-model="formInputs" @saveCard="saveCard" @cancelForm="cancelForm" v-if="formNewCard">
    </user-Board-form-card>
</div>
</template>

<script type="application/javascript">
import UserBoardFormCard from './UserBoardCardForm.vue'

export default {
    props: {
        user: Object,
        boardId: [Number, String],
        loadBoardUrl: String,
        saveLaneUrl: String,
        saveCardUrl: String,
    },
    components: {
        UserBoardFormCard
    },
    data() {
        return {
            board: null,
            cardMove: {},
            formInputs: {
                date: '',
            },
            formErrors: [],
            formNewCard: false,
            lanes_id: null,
        }
    },
    created: function() {
        const service = Vue.$dragula.$service
        service.options('events', {
            direction: 'vertical'
        })

        let serviceEvent = this.$dragula.createService({
            name: 'events',
            drake: {
                copy: true
            }
        })
        serviceEvent.on({
            drop: (opts) => {
                const {el,container,model} = opts
                this.cardMove.id = el.attributes.idcard.value
                this.cardMove.lanes_id = container.attributes.idlane.value
                this.updateCard()
            },
        })
    },
    methods: {
        strFormat: window.strFormat,
        loadBoard: function() {
            this.$http.get(this.loadBoardUrl)
               .then(function(response) {
                  this.board = response.data
            })
        },
        handleCommand(command) {
            if (command.substring(1) == "addCard") {
                this.formNewCard = true
                this.lanes_id = parseInt(command.substring(0, 1))
            }
        },
        saveLane: function() {
            this.formErrors = []
            this.$http.post(this.saveLaneUrl, this.formInputs)
                .then((response) => {
                    this.loadBoard();
                    this.$notify({
                        title: 'Success',
                        message: 'New lane',
                        type: 'success'
                    });
                }, (response) => {
                    this.formErrors = response.data;
                    this.$notify.error({
                        title: 'Error',
                        message: 'Can not add new lane'
                    });
                });
        },
        saveCard: function() {
            this.formNewCard = false
            this.formInputs.lanes_id = this.lanes_id
            this.formInputs.user_id = this.user.id
            this.formErrors = []
            this.$http.post(this.saveCardUrl, this.formInputs)
                .then((response) => {
                    this.loadBoard();
                    this.$notify({
                        title: 'Success',
                        message: 'New card',
                        type: 'success'
                    });
                }, (response) => {
                    this.formErrors = response.data;
                    console.log(response.data);
                    this.$notify.error({
                        title: 'Error',
                        message: 'Can not add new cane'
                    });
                });
        },
        updateCard: function() {
            this.formErrors = [];
            this.$http.put(this.saveCardUrl + '/' + this.cardMove.id, this.cardMove)
                .then((response) => {
                    //this.loadBoard();
                }, (response) => {
                    this.formErrors = response.data;
                });
        },
        cancelForm: function() {
            this.formNewCard = false
        },
    },
    mounted() {
        console.log('Component mounted.')
        this.loadBoard();
    }
}
</script>

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
    position: fixed !important;
    margin: 0 !important;
    z-index: 9999 !important;
    opacity: 0.8;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
    filter: alpha(opacity=80);
}

.gu-hide {
    display: none !important;
}

.gu-unselectable {
    -webkit-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
    user-select: none !important;
}

.gu-transit {
    opacity: 0.2;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
    filter: alpha(opacity=20);
}

.handle {
    padding: 0 5px;
    margin-right: 5px;
    background-color: rgba(0, 0, 0, 0.4);
    cursor: move;
}
</style>

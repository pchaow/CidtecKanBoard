<template>
    <div class="row" v-if="board">
        <div class="col-md-12" style="height : calc(100vh - 190px)">
            <div class="row-fluid" style="height:inherit">
                <div v-for="lane in board.lanes" class="col-md-3" style="">
                    <div class="panel panel-success lane" style="">
                        <div class="panel-heading">
                            {{lane.name}}
                            <div class="pull-right">
                                <el-dropdown trigger="click" @command="handleCommand">
                                        <span class="el-dropdown-link">
                                       <i class="el-icon-caret-bottom el-icon--right"></i>
                                    </span>
                                    <el-dropdown-menu slot="dropdown">
                                        <el-dropdown-item :command="lane.name+'//addCard'">Add Card</el-dropdown-item>
                                    </el-dropdown-menu>
                                </el-dropdown>
                            </div>
                        </div>
                        <div class="panel-body nopadding">
                            <div class="wrapper">
                                <div class="card" v-dragula="Lane" drake="events" service="events" :idLane="lane.id">
                                    <div v-for="card in lane.cards" @click="openCard(card,lane.name)" :idCard="card.id">
                                        <div>
                                            <span style="display:block;float:left;"><b>{{card.name}}</b></span>
                                            <div class="panel" style="display:block;float:right"
                                                 :style="{'background-color': getColor(card.duedate,board.sprint)}">
                                            </div>
                                            <div v-if="card.checklists.length > 0"
                                                 style="display:block;float:right;margin-top: -10px;">
                                                <i class="fa fa-check-square-o"
                                                   aria-hidden="true">{{getCheklist(card.checklists)}}/{{card.checklists.length}}</i>
                                            </div>

                                        </div>
                                        <br>

                                        <b>มอบหมายให้ <span v-if="card.members_card.length == 0"> - </span></b>
                                        <ul style="padding-left: 20px;" v-if="card.members_card.length > 0">
                                            <li v-for="member in card.members_card">{{member.name}}</li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <form class="form-inline" v-on:submit.prevent="saveLane">
                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                            <input type="text" class="form-control" placeholder="add new lane.."
                                   v-model="formInputs.name" required/>
                            <span v-if="formErrors['name']" class="help-block">{{ formErrors['name'] }}</span>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<style type="text/css">
    .lane {
        height: calc(100vh - 230px);
        margin-bottom: 0px;
    }

    .nopadding {
        padding: 0px;
    }

    .wrapper {
        height: calc(100vh - 274px);
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

    .absolute {
        position: absolute;

    }
</style>


<script type="application/javascript">
    import '!style!css!../../../css/card.css';
    import moment from 'moment';

    export default {
        props: {
            user: Object,
            boardId: [Number, String],
            loadBoardUrl: String,
            saveLaneUrl: String,
            saveCardUrl: String,
        },
        components: {},
        data() {
            return {
                board: null,
                card: null,
                cardMove: {},
                formInputs: {},
                formErrors: [],
                lanes_id: null,
            }
        },
        created: function () {

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
                drop: (opts, w) => {
                    const {el, container, source, model} = opts
                    this.cardMove.id = el.attributes.idcard.value
                    this.cardMove.lanes_id = container.attributes.idlane.value
                    //
                    this.$nextTick(function () {
                        this.moveData = [];
                        this.beforeLane = [];
                        this.afterLane = [];
                        this.cardMove.lane_from = source.attributes.idlane.value;

                        for (var i = 0; i < source.childNodes.length; i++) {
                            this.beforeLane.push({
                                lane: source.attributes.idlane.value,
                                id: source.childNodes[i].attributes.idcard.value,
                                rank: i + 1
                            })
                        }

                        for (var i = 0; i < container.childNodes.length; i++) {
                            this.afterLane.push({
                                lane: container.attributes.idlane.value,
                                id: container.childNodes[i].attributes.idcard.value,
                                rank: i + 1
                            })
                        }
                        this.moveData.push(this.cardMove);
                        this.moveData.push(this.beforeLane);
                        this.moveData.push(this.afterLane);
                        this.moveCard()
                    });

                }
            })
        },
        methods: {
            strFormat: window.strFormat,
            loadBoard: function () {
                this.$http.get(this.loadBoardUrl)
                    .then(function (response) {
                        this.board = response.data
                    })
            },
            handleCommand(command) {
                let res = command.split("//")
                if (res[1] === "addCard") {
                    this.laneName = res[0]
                    window.location.href = '/' + this.user.username + '/' + this.board.name + '/' + this.laneName + '/cards/new'
                }
            },
            getColor: function (due, duration) {
                if (moment().format('YYYY-MM-DD') > due) {
                    return 'Gray'
                } else if (moment().format('YYYY-MM-DD') === due || moment().add(duration, 'days').format('YYYY-MM-DD') >= due) {
                    return 'Green';
                } else {
                    return 'Blue '
                }
            },
            saveLane: function () {
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
            openCard: function (card, lane) {

                window.location.href = '/' + this.user.username + '/' + this.board.name + '/' + lane + '/cards/' + card.id

            },
            moveCard: function () {
                this.formErrors = []
                this.$http.put(this.saveCardUrl + '/' + this.cardMove.id, this.moveData)
                    .then((response) => {
                        console.log(response.data);
                        //this.loadBoard();
                    }, (response) => {
                        this.formErrors = response.data;
                    });
            },
            updateCard: function () {
                this.formCard = false
                this.formErrors = []
                this.$http.put(this.saveCardUrl + '/' + this.card.id, this.formInputs)
                    .then((response) => {
                        this.loadBoard();
                    }, (response) => {
                        this.formErrors = response.data;
                    });
            },
            update: function () {
                this.loadBoard();
            },
            getCheklist: function (checklist) {
                let checked = 0;
                checklist.forEach(function (val) {
                    if (val.completed) {
                        checked++;
                    }
                });
                return checked;
            }
        },
        mounted() {
            this.loadBoard();
        }
    }
</script>


<template>
    <div class="row">
        <div class="col-md-12">
            <h3 v-if="checkEdit">แก้ไขการ์ด : <b>{{title}}</b></h3>
            <h3 v-else>เพิ่มการ์ด</h3>
            <span>{{createBy}}</span>
            <hr/>
            <div class="row">
                <div class="col-lg-8">
                    <form class="form-horizontal" v-on:submit.prevent="save">
                        <div class="form-group col-md-12" v-bind:class="{ 'has-error': formErrors['name'] }">
                            <label class="control-label">Name : </label>
                            <input type="text" class="form-control" placeholder="Name" v-model="formInputs.name"
                                   required/>
                            <span v-if="formErrors['name']" class="help-block">{{ formErrors['name'] }}</span>
                        </div>

                        <div class="form-group col-md-12" v-bind:class="{ 'has-error': formErrors['description'] }">
                            <label class="control-label">Description : </label>
                            <textarea rows="5" class="form-control" placeholder="Description"
                                      v-model="formInputs.description"></textarea>
                            <span v-if="formErrors['description']"
                                  class="help-block">{{ formErrors['description'] }}</span>
                        </div>

                        <div class="form-group col-md-12" v-bind:class="{ 'has-error': formErrors['duedate'] }">
                            <label class="control-label">Due Date : </label><br>
                            <input type="date" v-model="formInputs.duedate" placeholder="Due Date">
                            <span v-if="formErrors['date']" class="help-block">{{ formErrors['date'] }}</span>
                        </div>

                        <div class="form-group col-md-12" v-bind:class="{ 'has-error': formErrors['checklist'] }">
                            <label class="control-label">Checklist : </label>
                            <div class="input-group">
                                <input v-on:keydown.enter.prevent="addChecklist" type="text" class="form-control" placeholder="What needs to be done?"
                                       v-model="newChecklist"/>
                                <span v-if="formErrors['checklist']"
                                      class="help-block">{{ formErrors['checklist'] }}</span>
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="button" @click="addChecklist">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group  col-md-12 ">
                            <div class="list-group">
                                <div class="list-group-item clearfix" v-for="checkItem in formInputs.checklists">
                                    <div class="checklist-form" v-if="checkItem != editedChecklist">
                                        <input type="checkbox" v-model="checkItem.completed"/>
                                        <s v-if="checkItem.completed">{{checkItem.title}}</s>
                                        <span v-else>{{checkItem.title}}</span>

                                        <div class="pull-right">
                                            <button class="btn btn-xs btn-primary" @click="editChecklist(checkItem)"
                                                    type="button">Edit
                                            </button>
                                            <button class="btn btn-xs btn-danger" @click="removeChecklist(checkItem)"
                                                    type="button">Delete
                                            </button>
                                        </div>

                                    </div>

                                    <div class="checklist-edit" v-if="checkItem == editedChecklist">
                                        <div class="row">
                                            <div class="col-xs-9">
                                                <div class="form-inline">
                                                    <label>Title : </label>
                                                    <input type="text" class="form-control" v-model="checkItem.title">
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="pull-right">
                                                    <button class="btn btn-xs btn-primary" @click="doneEdit(checkItem)"
                                                            type="button">Save
                                                    </button>
                                                    <button class="btn btn-xs btn-default"
                                                            @click="cancelEdit(checkItem)"
                                                            type="button">Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="form-group  col-md-12 ">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a :href="strFormat('/{user}/{board}',{user : board.user.username, board : board.name})"
                                   class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <label class="control-label">มอบหมายให้ : </label>
                        <div class="col-md-12" v-if="formInputs.members_card.length > 0 ">
                            <ul class="list-group">
                                <li v-for="user in formInputs.members_card" :key="user.id" class="list-group-item">
                                    <span class="badge" style="cursor: pointer" @click="removeMember(user)">X</span>
                                    {{ user.name }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group autocomplete">
                                <vue-typeahead :local="allUsers" :default-suggestion="true" display-key='name'
                                               v-on:selected="done" v-model="checkedNames" classes="form-control">
                                </vue-typeahead>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" @click="saveMember"
                                            :disabled="checkMember">Add</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" v-if="checkEdit">
                    <hr/>
                    <h3>ลบการ์ด</h3>
                    <span>หากลบการ์ดแล้ว ไม่สามารถกู้คืนข้อมูลได้ กรุณาใช้ความระมัดระวัง</span>
                    <form v-on:submit.prevent="delCard">
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                Delete Card
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="application/javascript">
    export default {
        props: {
            saveCardUrl: String,
            loadCardUrl: String,
            loadMemberUrl: String,
            user: Object,
            lane: Object,
            board: Object,
        },
        data() {
            return {
                checkMember: true,
                checkedNames: null,
                checkSelected: false,
                checkEdit: false,
                newChecklist: '',
                editedChecklist: null,
                visibility: 'all',
                title: 'New Card',
                createBy: '',
                allUsers: [],
                formErrors: [],
                formInputs: {
                    name: '',
                    description: '',
                    date: [],
                    startdate: null,
                    duedate: null,
                    checklists: this.fetchChecklist(),
                    lanes_id: this.lane.id,
                    user_id: this.user.id,
                    members_card: [],
                }
            }
        },
        computed: {
            filteredChecklists: function () {
                return this.formInputs.checklists
            }
        },
        watch: {
            checkedNames: function (val) {
                if (this.checkSelected) {
                    this.checkMember = false
                    this.checkSelected = false
                } else {
                    this.checkMember = true
                }
            }
        },
        methods: {
            strFormat: window.strFormat,
            fetchChecklist: function () {
                var checklists = []
                return checklists
            },
            done: function (data) {
                this.checkMember = false
                this.checkSelected = true
                this.member = data
            },
            save: function () {
                this.formErrors = []
                console.log(this.editedChecklist)
                if ( this.editedChecklist != null ) {
                    this.cancelEdit();
                }
                if (this.checkEdit) {
                    this.saveEditCard()
                } else {
                    this.saveNewCard()
                }

            },
            saveNewCard: function () {
                this.$http.post(this.saveCardUrl, this.formInputs)
                    .then((response) => {
                        window.location.href = this.strFormat('/{user}/{board}', {
                            user: this.board.user.username,
                            board: this.board.name
                        })
                    }, (response) => {
                        this.formErrors = response.data;
                        console.log(this.formErrors);
                        this.$notify.error({
                            title: 'Error',
                            message: 'Can not add new card'
                        });
                    });
            },
            saveEditCard: function () {
                this.$http.put(this.saveCardUrl, this.formInputs)
                    .then((response) => {
                        window.location.href = this.strFormat('/{user}/{board}', {
                            user: this.board.user.username,
                            board: this.board.name
                        })
                    }, (response) => {
                        this.formErrors = response.data;
                        console.log(this.formErrors);
                        this.$notify.error({
                            title: 'Error',
                            message: 'Can not edit card'
                        });
                    });
            },
            addChecklist: function () {
                var formInputs = this.newChecklist && this.newChecklist.trim()
                if (!formInputs) {
                    return
                }
                this.formInputs.checklists.push({
                    title: formInputs,
                    completed: false
                })
                this.newChecklist = ''
            },
            removeChecklist: function (checklist) {
                this.formInputs.checklists.splice(this.formInputs.checklists.indexOf(checklist), 1)
            },
            editChecklist: function (checklist) {
                this.beforeEditCache = checklist.title
                this.editedChecklist = checklist

            },
            doneEdit: function (checklist) {
                if (!this.editedChecklist) {
                    return
                }
                this.editedChecklist = null
                checklist.title = checklist.title.trim()
                if (!checklist.title) {
                    this.removeChecklist(checklist)
                }
            },
            cancelEdit: function (checklist) {
                this.editedChecklist = null
                checklist.title = this.beforeEditCache
            },
            removeCompleted: function () {
                this.formInputs.checklists = filters.active(this.formInputs.checklists)
            },
            saveMember: function () {
                this.checkedNames = null
                this.formInputs.members_card.push({
                    id: this.member.id,
                    name: this.member.name
                })
                this.allUsers.splice(this.allUsers.indexOf(this.member), 1)
            },
            removeMember: function (member) {
                this.formInputs.members_card.splice(this.formInputs.members_card.indexOf(member), 1)
                this.allUsers.push(member)
            },
            loadUser: function () {
                this.$http.get(this.loadMemberUrl)
                    .then((response) => {
                        this.allUsers = response.data
                        console.log(this.allUsers);
                    }, (response) => {
                        this.formErrors = response.data;
                        console.log(this.formErrors)
                    });
            },
            loadCard: function () {
                if (this.loadCardUrl) {
                    this.$http.get(this.loadCardUrl)
                        .then((response) => {
                            if (this.user.id == response.data.owner_card.id) {
                                this.checkEdit = true
                            }
                            this.title = response.data.name
                            this.createBy = '#Create By ' + response.data.owner_card.name
                            this.formInputs = response.data
                            var startdate = new Date(response.data.startdate);
                            var duedate = new Date(response.data.duedate);
                            console.log(this.formInputs);
                        }, (response) => {
                            this.formErrors = response.data;
                            console.log(this.formErrors)
                        });
                }
            },
            delCard: function () {
                if (confirm('คุณต้องการลบการ์ดนี้ใช่ไหม')) {
                    if (this.loadCardUrl) {
                        this.$http.delete(this.loadCardUrl)
                            .then((response) => {
                                window.location.href = this.strFormat('/{user}/{board}', {
                                    user: this.board.user.username,
                                    board: this.board.name
                                })
                            }, (response) => {
                                this.formErrors = response.data;
                                console.log(this.formErrors)
                            });
                    }
                }
            }
        },
        mounted() {
            this.loadCard()
            this.loadUser()
        }
    }
</script>

<style>

    /*...............*/

    /*Member list css*/

    /*...............*/

    .member-list {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .member-list li {
        position: relative;
        border-bottom: 1px solid #ededed;
    }

    .member-list li label {
        word-break: break-all;
        padding: 15px 60px 15px 15px;
        display: block;
        line-height: 1.2;
        transition: color 0.4s;
    }

    .member-list li .destroy {
        cursor: pointer;
        background: none;
        display: none;
        position: absolute;
        border-bottom: 0px;
        top: 0;
        right: 10px;
        bottom: 0;
        width: 40px;
        height: 40px;
        margin: auto 0;
        font-size: 30px;
        transition: color 0.2s ease-out;
    }

    .member-list li .destroy:hover {
        color: #af5b5e;
    }

    .member-list li .destroy:after {
        content: '×';
    }

    .member-list li:hover .destroy {
        display: block;
    }
</style>
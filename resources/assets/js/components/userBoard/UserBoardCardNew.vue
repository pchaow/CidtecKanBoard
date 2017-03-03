<template>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                New Card
            </div>
            <div class="panel-body">

                <div class="col-lg-8">
                    <form class="form-horizontal" v-on:submit.prevent="save">
                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                            <label class="control-label">Name : </label>
                            <input type="text" class="form-control" placeholder="Name" v-model="formInputs.name" required/>
                            <span v-if="formErrors['name']" class="help-block">{{ formErrors['name'] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['description'] }">
                            <label class="control-label">Description : </label>
                            <textarea rows="5" class="form-control" placeholder="Description" v-model="formInputs.description"></textarea>
                            <span v-if="formErrors['description']" class="help-block">{{ formErrors['description'] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['date'] }">
                            <label class="control-label">Date : </label><br>
                            <el-date-picker v-model="formInputs.date" type="daterange" placeholder="Pick a range">
                            </el-date-picker>
                            <span v-if="formErrors['date']" class="help-block">{{ formErrors['date'] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['checklist'] }">
                            <label class="control-label">Checklist : </label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="What needs to be done?" v-model="newChecklist" />
                                <span v-if="formErrors['checklist']" class="help-block">{{ formErrors['checklist'] }}</span>
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="button" @click="addChecklist">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <ul class="checklist-list">
                                    <li v-for="checklist in filteredChecklists" class="checklist" :key="checklist.id" :class="{ completed: checklist.completed, editing: checklist == editedChecklist }">
                                        <div class="view">
                                            <input type="checkbox" class="toggle" v-model="checklist.completed">
                                            <label @click="editChecklist(checklist)">{{ checklist.title }}</label>
                                            <li class="destroy" @click="removeChecklist(checklist)"></li>
                                        </div>
                                        <el-form :inline="true" class="edit">

                                            <el-form-item :label-width="formLabelWidth">
                                                <el-input type="text" v-model="checklist.title"></el-input>
                                            </el-form-item>
                                            <el-form-item>
                                                <el-button type="primary" @click="doneEdit(checklist)">Edit</el-button>
                                            </el-form-item>
                                            <el-form-item>
                                                <el-button @click="cancelEdit(checklist)">Cencel</el-button>
                                            </el-form-item>
                                        </el-form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a :href="strFormat('/{user}/{board}',{user : user.username, board:boardName})" class="btn btn-default">Cancel</a>
                        </div>

                    </form>

                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">Member</div>
                        <div class="panel-body">
                            <div class="input-group autocomplete">
                                <vue-typeahead
                                :local="allUsers"
                                :default-suggestion="true"
                                display-key='name'
                                v-on:selected="done"
                                v-model="checkedNames"
                                classes="form-control">
                                </vue-typeahead>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" @click="saveMember" :disabled="checkMember">Add</button>
                              </span>
                            </div>
                            <ul class="member-list">
                                <li v-for="user in formInputs.memberCard"  :key="user.id">
                                    <div class="view">
                                        <label>{{ user.name }}</label>
                                        <li class="destroy" @click="removeMember(user)"></li>
                                    </div>
                                </li>
                             <ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script type="application/javascript">
export default {
    props: {
        saveCardUrl: String,
        loadMemberUrl: String,
        user: Object,
        lane: Object,
        boardName: String,
    },
    data() {
        return {
            newChecklist: '',
            editedChecklist: null,
            visibility: 'all',
            checkMember: true,
            checkedNames: null,
            checkSelected: false,
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
                memberCard: []
            }
        }
    },
    computed: {
        filteredChecklists: function() {
            return this.formInputs.checklists
        }
    },
    watch: {
        checkedNames: function(val) {
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
        fetchChecklist: function() {
            var checklists = []
            return checklists
        },
        done: function(data) {
            this.checkMember = false
            this.checkSelected = true
            this.member = data
        },
        save: function() {

            if (this.formInputs.date.length == 2) {
                this.formInputs.startdate = this.formInputs.date[0].getFullYear() + '-' + (this.formInputs.date[0].getMonth() + 1) + '-' + this.formInputs.date[0].getDate()
                this.formInputs.duedate = this.formInputs.date[1].getFullYear() + '-' + (this.formInputs.date[1].getMonth() + 1) + '-' + this.formInputs.date[1].getDate()
            }

            this.formErrors = []
            this.$http.post(this.saveCardUrl, this.formInputs)
                .then((response) => {
                    window.location.href = this.strFormat('/{user}/{board}', {
                        user: this.user.username,
                        board: this.boardName
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
        addChecklist: function() {
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
        removeChecklist: function(checklist) {
            this.formInputs.checklists.splice(this.formInputs.checklists.indexOf(checklist), 1)
        },
        editChecklist: function(checklist) {
            this.beforeEditCache = checklist.title
            this.editedChecklist = checklist

        },
        doneEdit: function(checklist) {
            if (!this.editedChecklist) {
                return
            }
            this.editedChecklist = null
            checklist.title = checklist.title.trim()
            if (!checklist.title) {
                this.removeChecklist(checklist)
            }
        },
        cancelEdit: function(checklist) {
            this.editedChecklist = null
            checklist.title = this.beforeEditCache
        },
        removeCompleted: function() {
            this.formInputs.checklists = filters.active(this.formInputs.checklists)
        },
        saveMember: function() {
          this.checkedNames = null
          this.formInputs.memberCard.push({
            id: this.member.id,
            name: this.member.name
          })
          this.allUsers.splice(this.allUsers.indexOf(this.member), 1)
        },
        removeMember: function(member) {
            this.formInputs.memberCard.splice(this.formInputs.memberCard.indexOf(member), 1)
            this.allUsers.push(member)
        },
        loadUser: function() {
            this.$http.get(this.loadMemberUrl)
                .then((response) => {
                    this.allUsers = response.data
                    console.log(this.allUsers);
                }, (response) => {
                    this.formErrors = response.data;
                    console.log(this.formErrors)
                });
        }
    },
    mounted() {
        this.loadUser()
    }
}
</script>

<style>
.row-checklist {
    white-space: nowrap;
    max-height: 100px;
    overflow-y: scroll;
}

label[for='toggle-all'] {
    display: none;
}

.checklist-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.checklist-list li {
    position: relative;
    border-bottom: 1px solid #ededed;
}

.checklist-list li.editing {
    border-bottom: none;
    padding: 0;
}

.checklist-list li.editing .edit {
    display: block;
}

.checklist-list li.editing .view {
    display: none;
}

.checklist-list li .toggle {
    width: 40px;
    height: auto;
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto 0;
}

.checklist-list li label {
    word-break: break-all;
    padding: 15px 60px 15px 15px;
    margin-left: 45px;
    display: block;
    line-height: 1.2;
    transition: color 0.4s;
}

.checklist-list li.completed label {
    color: #d9d9d9;
    text-decoration: line-through;
}

.checklist-list li .destroy {
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

.checklist-list li .destroy:hover {
    color: #af5b5e;
}

.checklist-list li .destroy:after {
    content: '×';
}

.checklist-list li:hover .destroy {
    display: block;
}

.checklist-list li .edit {
    display: none;
}

.checklist-list li.editing:last-child {
    margin-bottom: -1px;
}

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

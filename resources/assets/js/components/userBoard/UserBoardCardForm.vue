<template>
<!--  Dialog Form New Card-->
<el-dialog title="New Card" v-model="formNewCard">
    <el-form :model="dataNewCard" :rules="rulesCard" ref="dataNewCard">
        <el-form-item label="Name" prop="name" :label-width="formLabelWidth">
            <el-input v-model="dataNewCard.name" auto-complete="off" laceholder="Please input name"></el-input>
        </el-form-item>
        <el-form-item label="Description" prop="description" :label-width="formLabelWidth">
            <el-input type="textarea" v-model="dataNewCard.description"></el-input>
        </el-form-item>
        <el-form-item label="Date" prop="date" :label-width="formLabelWidth" required>
            <el-date-picker v-model="dataNewCard.date" type="daterange" placeholder="Pick a range">
            </el-date-picker>
        </el-form-item>


        <el-form :inline="true" :model="dataNewCard">
            <el-form-item label="Checklist" prop="checklist" :label-width="formLabelWidth">
                <el-input v-model="newChecklist" auto-complete="off" laceholder="What needs to be done?"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="addChecklist">Add</el-button>
            </el-form-item>
        </el-form>

        <el-form-item label="Lists" :label-width="formLabelWidth">
            <div class="row-checklist">
                <ul class="checklist-list">
                    <li v-for="checklist in filteredChecklists" class="checklist" :key="checklist.id" :class="{ completed: checklist.completed, editing: checklist == editedChecklist }">
                        <div class="view">
                            <input class="toggle" type="checkbox" v-model="checklist.completed">
                            <label @dblclick="editChecklist(checklist)">{{ checklist.title }}</label>
                            <li class="destroy" @click="removeChecklist(checklist)"></li>
                        </div>
                        <input class="edit" type="text" v-model="checklist.title" @blur="doneEdit(checklist)" @keyup.enter="doneEdit(checklist)" @keyup.esc="cancelEdit(checklist)">
                    </li>
                </ul>
            </div>
            <el-form-item>
    </el-form>



    <span slot="footer" class="dialog-footer">
          <el-button @click="formNewCard = false">Cancel</el-button>
          <el-button type="primary" @click="saveCard('dataNewCard')">Confirm</el-button>
    </span>
</el-dialog>
</template>


<script type="application/javascript">
var checklistStorage = {
    fetchChecklist: function() {
        var checklists = []
        checklists.forEach(function(checklist, index) {
            checklists.id = index
        })
        checklistStorage.uid = checklists.length
        return checklists
    }
}

// visibility filters
var filters = {
    all: function(checklists) {
        return checklists
    },
    active: function(checklists) {
        return checklists.filter(function(checklist) {
            return !checklist.completed
        })
    },
    completed: function(checklists) {
        return checklists.filter(function(checklist) {
            return checklist.completed
        })
    }
}

export default {
    props: ['value'],
    data() {
        return {
            newChecklist: '',
            checklistStorage: {
                name: "null"
            },
            editedChecklist: null,
            visibility: 'all',
            formNewCard: true,
            formLabelWidth: '120px',
            dataNewCard: {
                name: '',
                description: '',
                date: '',
                startdate: '',
                duedate: '',
                checklists: checklistStorage.fetchChecklist(),
            },
            rulesCard: {
                name: [{
                        required: true,
                        message: 'Please input name',
                        trigger: 'blur'
                    },
                    {
                        min: 3,
                        max: 20,
                        message: 'Length should be 3 to 20',
                        trigger: 'blur'
                    }
                ]
            }
        }
    },
    computed: {
        filteredChecklists: function() {
            return filters[this.visibility](this.dataNewCard.checklists)
        },
        remaining: function() {
            return filters.active(this.dataNewCard.checklists).length
        }
    },
    watch: {
        formNewCard: function(val) {
            this.$emit('cancelForm')
            this.formNewCard = false
        }
    },
    filters: {
        pluralize: function(n) {
            return n === 1 ? 'item' : 'items'
        }
    },
    methods: {
        saveCard: function(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.dataNewCard.startdate = this.dataNewCard.date[0].getFullYear() + '-' + (this.dataNewCard.date[0].getMonth() + 1) + '-' + this.dataNewCard.date[0].getDate()
                    this.dataNewCard.duedate = this.dataNewCard.date[1].getFullYear() + '-' + (this.dataNewCard.date[1].getMonth() + 1) + '-' + this.dataNewCard.date[1].getDate()

                    this.$emit('input', {
                        name: this.dataNewCard.name,
                        description: this.dataNewCard.description,
                        startdate: this.dataNewCard.startdate,
                        duedate: this.dataNewCard.duedate,
                        checklists: JSON.stringify(this.dataNewCard.checklists),
                    })
                    this.$emit('saveCard')
                    this.formNewCard = false
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        addChecklist: function() {
            console.log(this.newChecklist)
            var value = this.newChecklist && this.newChecklist.trim()
            if (!value) {
                return
            }
            this.dataNewCard.checklists.push({
                id: checklistStorage.uid++,
                title: value,
                completed: false
            })
            this.newChecklist = ''
        },

        removeChecklist: function(checklist) {
            this.dataNewCard.checklists.splice(this.dataNewCard.checklists.indexOf(checklist), 1)
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
            this.dataNewCard.checklists = filters.active(this.dataNewCard.checklists)
        },
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
    text-align: center;
    width: 40px;
    /* auto, since non-WebKit browsers doesn't support input styling */
    height: auto;
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto 0;
    border: none;
    /* Mobile Safari */
    -webkit-appearance: none;
    appearance: none;
}

.checklist-list li .toggle:after {
    content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="-10 -18 100 135"><circle cx="50" cy="50" r="50" fill="none" stroke="#ededed" stroke-width="3"/></svg>');
}

.checklist-list li .toggle:checked:after {
    content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="-10 -18 100 135"><circle cx="50" cy="50" r="50" fill="none" stroke="#bddad5" stroke-width="3"/><path fill="#5dc2af" d="M72 25L42 71 27 56l-4 4 20 20 34-52z"/></svg>');
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
    top: 0;
    right: 10px;
    bottom: 0;
    width: 40px;
    height: 40px;
    margin: auto 0;
    font-size: 30px;
    color: #cc9a9a;
    margin-bottom: 11px;
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
</style>

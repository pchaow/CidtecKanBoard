<template>
<!--  Dialog Form New Card-->
<el-dialog title="New Card" v-model="formNewCard">
    <el-form :model="form">
        <el-form-item label="Name" :label-width="formLabelWidth">
            <el-input v-model="name" auto-complete="off" laceholder="Please input name"></el-input>
        </el-form-item>
        <el-form-item label="Description" :label-width="formLabelWidth">
            <el-input type="textarea" v-model="description"></el-input>
        </el-form-item>
        <el-form-item label="Date" :label-width="formLabelWidth">
            <el-date-picker v-model="date" type="daterange" placeholder="Pick a range">
            </el-date-picker>
        </el-form-item>

    </el-form>
    <span slot="footer" class="dialog-footer">
          <el-button @click="cancelForm">Cancel</el-button>
          <el-button type="primary" @click="saveCard">Confirm</el-button>
    </span>
</el-dialog>
</template>


<script type="application/javascript">
export default {
    props: ['value'],
    data() {
        return {
            name: '',
            description: '',
            date: '',
            startdate: '',
            duedate: '',
            formNewCard: true,
            formLabelWidth: '120px',
        }
    },
    methods: {
        saveCard: function() {
            this.startdate = this.date[0].getFullYear() + '-' + (this.date[0].getMonth() + 1) + '-' + this.date[0].getDate()
            this.duedate = this.date[1].getFullYear() + '-' + (this.date[1].getMonth() + 1) + '-' + this.date[1].getDate()

            this.$emit('input', {
              name: this.name,
              description: this.description,
              startdate: this.startdate,
              duedate: this.duedate
            })
            this.$emit('saveCard')
            this.formNewCard = false
        },
        cancelForm: function() {
            this.$emit('cancelForm')
            this.formNewCard = false
        },
    }
}
</script>

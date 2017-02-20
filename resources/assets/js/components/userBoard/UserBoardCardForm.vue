<template>
<!--  Dialog Form New Card-->
<el-dialog title="New Card" v-model="formNewCard">
    <el-form :model="dataNewCard" :rules="rulesCard" ref="dataNewCard">
        <el-form-item label="Name" prop="name" :label-width="formLabelWidth">
            <el-input v-model="dataNewCard.name" auto-complete="off" laceholder="Please input name"></el-input>
        </el-form-item>
        <el-form-item label="Description" prop="description"  :label-width="formLabelWidth">
            <el-input type="textarea" v-model="dataNewCard.description"></el-input>
        </el-form-item>
        <el-form-item label="Date" prop="date" :label-width="formLabelWidth" required>
            <el-date-picker v-model="dataNewCard.date" type="daterange" placeholder="Pick a range">
            </el-date-picker>
        </el-form-item>

    </el-form>
    <span slot="footer" class="dialog-footer">
          <el-button @click="cancelForm">Cancel</el-button>
          <el-button type="primary" @click="saveCard('dataNewCard')">Confirm</el-button>
    </span>
</el-dialog>
</template>


<script type="application/javascript">
export default {
    props: ['value'],
    data() {
        return {
            dataNewCard: {
                name: '',
                description: '',
                date: '',
                startdate: '',
                duedate: '',
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
            },
            formNewCard: true,
            formLabelWidth: '120px',
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
                      duedate: this.dataNewCard.duedate
                  })
                  this.$emit('saveCard')
                  this.formNewCard = false
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        cancelForm: function() {
            this.$emit('cancelForm')
            this.formNewCard = false
        },
    }
}
</script>

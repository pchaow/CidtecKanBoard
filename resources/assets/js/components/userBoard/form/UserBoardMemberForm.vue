<template>
  <div class="col-lg-12">
      <ul class="list-group">
          <li v-for="member in members" class="list-group-item justify-content-between">
              {{member.name}}
              <span class="badge badge-primary badge-pill">x</span>
          </li>
      </ul>
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
                    <button class="btn btn-primary" @click="addMember" :disabled="checkMember">Add</button>
              </span>
          </div>
  </div>
</template>

<script type="application/javascript">
import '!style!css!../../../../css/autocomplete.css';

export default {
    props: {
        saveMemberUrl: String,
        loadMemberUrl: String,
        members: null,
    },
    data() {
        return {
            member: null,
            checkMember: true,
            checkedNames: null,
            checkSelected: false,
        }
    },
    watch: {
        checkedNames: function(val) {
          if (this.checkSelected) {
            this.checkMember = false
            this.checkSelected = false
          }else {
            this.checkMember = true
          }
        }
    },
    methods: {
        done: function(data) {
            this.checkMember = false
            this.checkSelected = true
            this.member = data
        },
        addMember: function() {
          this.formErrors = [];
          this.$http.post(this.saveMemberUrl, this.member)
              .then((response) => {
                this.$emit('load')
                this.members.push(this.member)
                this.loadUser()
                this.checkedNames = null
              }, (response) => {
                  this.formErrors = response.data;
                  console.log(this.formErrors);
              });
        },
        loadUser: function() {
            this.$http.get(this.loadMemberUrl)
                .then((response) => {
                  this.allUsers = response.data
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

<style type="text/css"></style>

<template>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                {{board.name}}
                <div class="btn-group btn-group-sm pull-right">
                    <a v-bind:href="'../'+board.name+'/edit'" class="btn btn-default">Edit</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <form class="form-horizontal" v-on:submit.prevent="save">
                      <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                          <label class="control-label">Name : </label>
                          <input type="text" class="form-control" placeholder="Name" v-model="formInputs.name"/>
                          <span v-if="formErrors['name']" class="help-block">{{ formErrors['name'] }}</span>
                      </div>

                      <div class="form-group" v-bind:class="{ 'has-error': formErrors['description'] }">
                          <label class="control-label">Description : </label>
                          <textarea rows="5" class="form-control" placeholder="Description" v-model="formInputs.description"></textarea>
                          <span v-if="formErrors['description']"
                                class="help-block">{{ formErrors['description'] }}</span>
                      </div>

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">Submit</button>
                          <a href="./" class="btn btn-default">Cancel</a>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
      saveUrl : String,
      loadUrl : String,
      successUrl : String,
    },
    data() {
        return {
            formInputs: {},
            formErrors: [],
            board: {},
        }
    },
    methods: {
      save: function () {
          this.formErrors = [];
          this.$http.put(this.saveUrl, this.formInputs)
                  .then((response) => {
                      //window.location.href = this.successUrl
                      console.log(response);
                      window.location.href = this.successUrl
                  }, (response) => {
                      this.formErrors = response.data;
                      //console.log(this.formErrors);
                  });
      },
        load: function() {
            this.$http.get(this.loadUrl)
                .then((response) => {
                    // success callback
                    this.board = response.data;
                    this.formInputs = response.data;
                    console.log(this.board)

                }, (response) => {
                    // error callback
                    this.formErrors = response.data;
                    console.log(this.formErrors)
                });
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.load()
    }
}
</script>

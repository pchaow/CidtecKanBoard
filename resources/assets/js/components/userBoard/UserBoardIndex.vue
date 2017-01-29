<template>
<div class="panel panel-info">
    <div class="panel-heading">Board</div>

    <div class="panel-body">
        <div class="">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="managementBoard in managementBoards">
                            <td>{{managementBoard.name}}</td>
                            <td>{{managementBoard.description}}</td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</template>

<script>
export default {
    props: {

        loadUserBoardsUrl: String,

    },
    data() {
        return {
            managementBoards: [],
        }
    },
    methods: {
        reset: function() {
            this.form = {
                keyword: ""
            }
        },
        load: function() {
            this.$http.get('/api/v1/board/all', {
                params: this.form
            }).then(function(r) {
                console.log(r.data)
                this.managementBoardPage = r.data
                this.managementBoards = this.managementBoardPage

                console.log(this.managementBoards)

            })
          }
        },
    mounted() {
        console.log('Component mounted.')
        this.load();
    }
}
</script>

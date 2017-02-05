<template>
<div class="panel panel-info">
    <div class="panel-heading">Board</div>

    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item" v-for="managementBoard in managementBoards">
                <span class="glyphicon glyphicon-blackboard"></span>
                <a v-bind:href="'/'+managementBoard.owner_board.username +'/board/' +managementBoard.name">{{ managementBoard.name }} </a>
            </li>
        </ul>

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
            this.$http.get('/api/v1/board/index', {
                params: this.form
            }).then(function(r) {
                console.log(r.data)
                this.managementBoardPage = r.data
                this.managementBoards = this.managementBoardPage
            })
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.load();
    }
}
</script>

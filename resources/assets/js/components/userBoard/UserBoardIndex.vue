<template>
    <div>
        <div class="panel panel-info" v-for="board in boards">
            <div class="panel-heading">
                <a :href="'/'+board.user.username+'/'+board.name" v-if="user.username === board.user.username">{{board.name}}</a>
                <a :href="'/'+board.user.username+'/'+board.name" v-else>{{board.user.username}}/{{board.name}}</a>
            </div>

            <div class="panel-body">
                List of current remaining tasks. "do it later"
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            loadUserBoardsUrl: String,
            user: Object,
        },
        data() {
            return {
                boards: [],
            }
        },
        methods: {
            reset: function () {
                this.form = {
                    keyword: ""
                }
            },
            load: function () {
                this.$http.get(this.loadUserBoardsUrl, {
                    params: this.form
                }).then(function (r) {
                    this.boards = r.data
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
            console.log(this.user)
            this.load();
        }
    }
</script>

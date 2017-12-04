<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #f6f8fa">
                Board List
            </div>

            <div class="panel-body" v-for="board in boards" style="border-bottom: 1px solid #e1e4e8 ">


                <div class="row" v-if="user.username === board.user.username">
                    <div class="col-md-4">
                        <a :href="'/'+board.user.username+'/'+board.name">
                        <h4 class="list-group-item-heading">{{board.name}}</h4>
                        </a>
                        <p class="list-group-item-text">ปรับปรุงล่าสุด : {{board.updated_at}}</p>
                    </div>
                    <div class="col-md-8">
                        <p class="list-group-item-text">{{board.description}}</p>
                    </div>

                </div>

                <div class="row" v-else>
                    <div class="col-md-4">
                        <a :href="'/'+board.user.username+'/'+board.name">
                        <h4 class="list-group-item-heading">{{board.user.username}}/{{board.name}}</h4>
                        </a>
                        <p class="list-group-item-text">ปรับปรุงล่าสุด : {{board.updated_at}}</p>
                    </div>
                    <div class="col-md-8">
                        <p class="list-group-item-text">{{board.description}}</p>
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

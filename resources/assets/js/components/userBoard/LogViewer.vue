<template>
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: #f6f8fa">
            Activity
        </div>
        <div style="max-height: 40vh;overflow: auto;overflow-x: hidden">
            <div class="panel-body" v-for="log in log_list" style="border-bottom: 1px solid #e1e4e8">
                <div class="row" style="margin-left: 5px;">
                    <i class="list-group-item-heading">
                        <span style="color: #2a88bd"> {{log.user.name}} </span>
                        {{log.action}} <span style="color: #2a88bd"> {{log.card.name}}</span>
                        <span v-if="log.lane_id">To  {{log.lane.name}}</span>
                    </i>
                    <p class="list-group-item-text">on : {{log.created_at}}</p>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            board: Object,
            card: Object,
            loadLogUrl: String
        },
        data() {
            return {
                log_list: []
            }
        },
        methods: {
            load: function () {
                this.$http.get(this.loadLogUrl).then((response) => {
                    if (response && response.data) {
                        this.log_list = response.data
                        console.log(this.log_list);
                    }
                })
            }
        },
        mounted() {
            this.load();
        }
    }
</script>

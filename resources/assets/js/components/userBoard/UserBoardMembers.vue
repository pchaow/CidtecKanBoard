<template>
    <div class="row" v-if="board">
        <div class="col-md-12">

            <h3>แก้ไขสมาชิก : {{board.name}}</h3>
            <hr/>
        </div>

                <user-board-form-member
                        :members="board.members_board"
                        :load-member-url="loadMemberUrl"
                        :save-member-url="saveMemberUrl"
                        @load="load">
                </user-board-form-member>

    </div>
</template>

<script type="application/javascript">
    import '!style!css!../../../css/autocomplete.css';

    export default {
        props: {
            saveUrl: String,
            loadUrl: String,
            deleteLaneUrl: String,
            successUrl: String,
            user: Object,
        },
        data() {
            return {
                formInputs: {},
                formErrors: [],
                board: {},
            }
        },
        methods: {
            strFormat: window.strFormat,
            addLane: function () {
                this.board.lanes.push({})
            },
            deleteLane: function (lane, index) {
                if (confirm('คุณต้องการลบแถวนี้ใช่หรือไม่')) {
                    if (lane.id) {
                        this.$http.delete(this.strFormat(this.deleteLaneUrl, {
                            id: lane.id
                        }), this.formInputs)
                            .then((response) => {
                                this.board.lanes.splice(index, 1)
                            }, (response) => {

                            });
                    } else {
                        this.board.lanes.splice(index, 1)
                    }
                }

            },
            save: function () {
                this.formErrors = [];
                this.$http.put(this.saveUrl, this.formInputs)
                    .then((response) => {
                        window.location.href = this.successUrl

                    }, (response) => {
                        this.formErrors = response.data;
                        //console.log(this.formErrors);
                    });
            },
            load: function () {
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

<style type="text/css">

</style>

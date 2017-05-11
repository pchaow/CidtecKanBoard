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
            saveMemberUrl: String,
            loadMemberUrl: String,
            successUrl: String,
            user: Object,
        },
        data() {
            return {
                formInputs: {},
                formErrors: [],
                board: {},
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
            strFormat: window.strFormat,
            done: function(data) {
                this.checkMember = false
                this.checkSelected = true
                this.member = data
            },

            addMember: function() {
                this.formErrors = [];
                this.$http.post(this.saveMemberUrl, this.member)
                    .then((response) => {
                        this.load()
                        this.checkedNames = null
                    }, (response) => {
                        this.formErrors = response.data;
                        console.log(this.formErrors);
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

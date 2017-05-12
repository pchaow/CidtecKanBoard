<template>
    <div class="row" v-if="board">
        <div class="col-md-12">

            <h3>แก้ไขแถว : {{board.name}}</h3>
            <span>หากลบแถวไปแล้ว จะไม่สามารถกู้คืนข้อมูลได้ กรุณาใช้ความระมัดระวัง</span>
            <hr/>
        </div>
        <div class="col-md-12">
            <form class="form-horizontal" v-on:submit.prevent="save">

                <div class="form-group col-md-12 ">
                    <button type="button" @click="addLane" class="btn btn-success">เพิ่มแถว</button>
                </div>


                <div v-for="(lane,index) in board.lanes" class="form-group col-md-12">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Name" v-model="lane.name"/>
                        <span class="input-group-btn">
                            <button class="btn btn-danger" @click="deleteLane(lane,index)" type="button">Delete</button>
                        </span>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="./" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
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
                if(confirm('คุณต้องการลบแถวนี้ใช่หรือไม่')){
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
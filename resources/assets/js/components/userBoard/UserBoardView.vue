<template>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                {{board.name}}
                <div class="btn-group btn-group-sm pull-right">
                    <a v-bind:href="board.name+'/edit'" class="btn btn-default">Edit</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="wrapper">
                        <div class="card" v-dragula="Ready" bag="first-bag">
                            <!-- with click -->
                            <div v-for="text in Ready" @click="onClick">{{text}} [click me]</div>
                        </div>
                        <div class="card" v-dragula="Doing" bag="first-bag">
                            <div v-for="text in Doing">{{text}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        editUrl: String,
        loadUrl: String,
    },
    data() {
        return {
            formInputs: {},
            formErrors: [],
            board: {},
            Ready: [
                'dear',
                'hi',
                'hello'
            ],
            Doing: [
                'test1',
                'test2',
                'test3'
            ]
        }
    },
    methods: {
        strFormat: window.strFormat,
        onClick: function() {
            console.log(Vue.vueDragula.find('first-bag'))
            window.alert('click event')
        },

        load: function() {
            this.$http.get(this.loadUrl)
                .then((response) => {
                    // success callback
                    this.board = response.data;
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
        Vue.vueDragula.eventBus.$on(
            'drop',
            function(args) {
                console.log('drop: ' + args[0])
            }
        )
    }
}
</script>
<style>
ul {
    margin: 0;
    padding: 0;
}

.parent {
    background-color: rgba(255, 255, 255, 0.2);
    margin: 50px 0;
    padding: 20px;
}

input {
    border: none;
    outline: none;
    background-color: #ecf0f1;
    padding: 10px;
    color: #942A57;
    border: 0;
    margin: 5px 0;
    display: block;
    width: 100%;
}

button {
    background-color: #ecf0f1;
    color: #942A57;
    border: 0;
    padding: 18px 12px;
    margin-left: 6px;
    cursor: pointer;
    outline: none;
}

button:hover {
    background-color: #e74c3c;
    color: #ecf0f1;
}

.gh-fork {
    position: fixed;
    top: 0;
    right: 0;
    border: 0;
}


/* dragula-specific example page styles */

.wrapper {
    display: table;
}

.card {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: rgba(255, 255, 255, 0.2);
}

.card:nth-child(odd) {
    background-color: rgba(0, 0, 0, 0.2);
}


/*
 * note that styling gu-mirror directly is a bad practice because it's too generic.
 * you're better off giving the draggable elements a unique class and styling that directly!
 */

.card div,
.gu-mirror {
    padding: 10px;
    background-color: rgba(0, 0, 0, 0.2);
    transition: opacity 0.4s ease-in-out;
}

.card div {
    cursor: move;
    cursor: grab;
    cursor: -moz-grab;
    cursor: -webkit-grab;
    margin-bottom: 10px;
}

.card div:last-child {
    margin-bottom: 0;
}

.gu-mirror {
    cursor: grabbing;
    cursor: -moz-grabbing;
    cursor: -webkit-grabbing;
}

.card .ex-moved {
    background-color: #e74c3c;
}

.card .ex-over {
    background-color: rgba(255, 255, 255, 0.3);
}

.handle {
    padding: 0 5px;
    margin-right: 5px;
    background-color: rgba(0, 0, 0, 0);
    cursor: move;
}


/* example styles */

.card .scale-transition {
    overflow: hidden;
    height: 40px;
    transition: height .2s;
}

.card .scale-enter {
    height: 0px;
}

.card .scale-leave {
    height: 0px;
}
</style>

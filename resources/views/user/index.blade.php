@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div class="row">
            <div class="col-md-8">
              <user-board-index
                      v-bind:user="{{json_encode(auth()->user())}}"
                      v-bind:load-user-boards-url="'/api/v1/user/{{auth()->id()}}/board'"></user-board-index>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Incomming Task</div>

                    <div class="panel-body">
                        List of task
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
@endsection

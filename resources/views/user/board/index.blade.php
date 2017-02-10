@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-view
                v-bind:user="{{json_encode(auth()->user())}}"
                v-bind:load-url="'/api/v1/user/{{auth()->id()}}/board'">
        </user-board-view>
    </div>
@endsection

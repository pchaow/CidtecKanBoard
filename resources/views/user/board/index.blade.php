@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-view
                v-bind:user="{{json_encode(auth()->user())}}"
                v-bind:board="{{json_encode($board)}}"
        >
        </user-board-view>
    </div>
@endsection

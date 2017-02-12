@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-view
                v-bind:user="{{json_encode(auth()->user())}}"
                v-bind:board-id="{{$boardId}}"
                load-board-url="/api/v1/user/{{auth()->user()->id}}/board/{{$boardId}}"
        >
        </user-board-view>
    </div>
@endsection

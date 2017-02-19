@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-view
                v-bind:user="{{json_encode(auth()->user())}}"
                v-bind:board-id="{{$board->id}}"
                load-board-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}"
                save-lane-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/lane"
        >
        </user-board-view>
    </div>
@endsection

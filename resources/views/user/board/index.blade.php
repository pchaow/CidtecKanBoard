@extends('layouts.container')

@section('header')
    @include('user.userboardhead')
    @include('user.userboardmenu')


@endsection
@section('content')
        <user-board-view
                v-bind:user="{{json_encode(auth()->user())}}"
                v-bind:board-id="{{$board->id}}"
                load-board-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}"
                save-lane-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/lane"
                save-card-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/card"
        >
        </user-board-view>
@endsection

@extends('layouts.container')

@section('header')
    @include('user.board.userboardhead')
    @include('user.board.userboardmenu')
@endsection

@section('content')
    <div id="app">
        <user-board-members
                :load-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}'"
                :save-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}'"
                :success-url="'/{{$user->username}}/{{$board->name}}'"
                :delete-lane-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}/lane/{id}'"
                :user="{{json_encode($user)}}"
        >
        </user-board-members>
    </div>
@endsection

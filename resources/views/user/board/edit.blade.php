@extends('layouts.container')

@section('header')
    @include('user.board.userboardhead')
    @include('user.board.userboardmenu')
@endsection

@section('content')
    <div id="app">
        <user-board-edit
                :load-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}'"
                :save-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}'"
                :success-url="'/{{$user->username}}/{{$board->name}}'"
                :user="{{json_encode($user)}}"
        >
        </user-board-edit>
    </div>
@endsection

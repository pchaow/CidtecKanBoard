@extends('layouts.container')

@section('header')
    @include('user.userboardhead')
    @include('user.userboardmenu')
@endsection

@section('content')
    <div id="app">
        <user-board-edit
                :load-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}'"
                :load-member-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}/member'"
                :save-member-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}/member'"
                :save-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}'"
                :success-url="'/{{$user->username}}/{{$board->name}}'"
                :delete-lane-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}/lane/{id}'"
                :user="{{json_encode($user)}}"
        >
        </user-board-edit>
    </div>
@endsection

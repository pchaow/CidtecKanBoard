@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-edit
                :load-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}'"
                :save-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}'"
                :success-url="'/{{$user->username}}/{{$board->name}}'"
                :delete-lane-url="'/api/v1/user/{{$user->id}}/board/{{$board->id or 0}}/lane/{id}'"
                :user="{{json_encode($user)}}"
        >
        </user-board-edit>
    </div>
@endsection

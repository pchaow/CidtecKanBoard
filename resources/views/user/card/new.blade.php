@extends('layouts.container')

@section('header')
    @include('user.board.userboardhead')
    @include('user.board.userboardmenu')
@endsection


@section('content')
        <user-board-card
                :user="{{json_encode(auth()->user())}}"
                :board="{{$board}}"
                :lane="{{$lane}}"
                save-card-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/card"
                load-member-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/member/create"
        >
      </user-board-card>
@endsection

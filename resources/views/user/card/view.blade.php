@extends('layouts.container')

@section('header')
    @include('user.board.userboardhead')
    @include('user.board.userboardmenu')
@endsection


@section('content')
    <div id="app">
      <user-board-card
              :user="{{$user}}"
              :board="{{$board}}"
              :lane="{{$lane}}"
              save-card-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/card/{{$cardId}}"
              load-card-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/card/{{$cardId}}"
              load-member-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/card/{{$cardId}}/member"
      >
    </user-board-card>

    </div>
@endsection

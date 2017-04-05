@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-card
                :user="{{json_encode(auth()->user())}}"
                :board="{{$board}}"
                :lane="{{$lane}}"
                save-card-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/card"
                load-member-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/member/create"
        >
      </user-board-card>
    </div>
@endsection

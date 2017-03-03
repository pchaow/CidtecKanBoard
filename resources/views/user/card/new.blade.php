@extends('layouts.container')

@section('container')
    <div id="app">
        <user-card-new
                :user="{{json_encode(auth()->user())}}"
                :board-name="{{$board->name}}"
                :lane="{{$lane}}"
                save-card-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/card"
                load-member-url="/api/v1/user/{{$user->id}}/board/{{$board->id}}/member/create"
        >
      </user-card-new>
    </div>
@endsection

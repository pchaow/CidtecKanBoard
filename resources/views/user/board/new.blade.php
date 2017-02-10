@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-new
                :user="{{json_encode(auth()->user())}}"
                save-url="/api/v1/user/{{auth()->id()}}/board"
        ></user-board-new>
    </div>
@endsection

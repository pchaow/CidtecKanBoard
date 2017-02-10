@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-new
                save-url="/api/v1/user/{{auth()->id()}}/board"
        ></user-board-new>
    </div>
@endsection

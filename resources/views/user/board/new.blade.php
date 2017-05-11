@extends('layouts.container')

@section('header')
    @include('user.userhead')
@endsection

@section('content')
        <user-board-new
                :user="{{json_encode(auth()->user())}}"
                save-url="/api/v1/user/{{auth()->id()}}/board"
        ></user-board-new>
@endsection

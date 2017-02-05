@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-view
                 v-bind:load-url="'/api/v1/board/view/{{$boardId or 0}}'">
        </user-board-view>
    </div>
@endsection

@extends('layouts.container')

@section('container')
    <div id="app">
        <user-board-edit
        v-bind:load-url="'/api/v1/board/view/{{$boardId or 0}}'"
        v-bind:save-url="'/api/v1/board/view/{{$boardId or 0}}'"
        v-bind:success-url="'../'">
      </user-board-edit>
    </div>
@endsection

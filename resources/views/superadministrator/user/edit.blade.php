@extends('layouts.container')

@section('container')
    <div id="app">
        <user-edit v-bind:user-id="{{$userId or 0}}"></user-edit>
    </div>

@endsection
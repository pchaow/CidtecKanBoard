@extends('layouts.container')

@section('container')
    <div id="app">
        <role-edit v-bind:role-id="{{$roleId or 0}}"></role-edit>
    </div>

@endsection
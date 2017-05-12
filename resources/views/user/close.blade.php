@extends('layouts.container')

@section('header')
    @include('user.userhead')
    @include('user.userheadmenu')
@endsection

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <user-board-index
                        v-bind:user="{{json_encode(auth()->user())}}"
                        v-bind:load-user-boards-url="'/api/v1/user/{{auth()->id()}}/board?close=true'"></user-board-index>
            </div>

        </div>
        <div class="row" style="display: none;">
            <div class="col-md-12">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
@endsection

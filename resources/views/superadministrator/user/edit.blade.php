@extends('layouts.container')

@section('container')
    <div id="app">
        <user-edit

                v-bind:save-url="'/api/v1/admin/user/{{$userId or 0}}'"
                v-bind:load-url="'/api/v1/admin/user/{{$userId or 0}}'"
                v-bind:success-url="'/superadministrator/user'"
                v-bind:load-roles-url="'/api/v1/admin/role'"
                v-bind:user-id="{{$userId or 0}}">
        </user-edit>

    </div>

@endsection
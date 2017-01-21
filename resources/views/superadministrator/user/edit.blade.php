@extends('layouts.container')

@section('container')
    <div id="app">
        <user-edit
                v-bind:save-prefix="'/api/v1/admin/user/'"
                v-bind:save-postfix="''"
                v-bind:load-prefix="'/api/v1/admin/user/'"
                v-bind:load-postfix="''"
                v-bind:success-url="'/superadministrator/user'"
                v-bind:load-roles-url="'/api/v1/admin/role'"
                v-bind:user-id="{{$userId or 0}}">
        </user-edit>

    </div>

@endsection
@extends('layouts.container')

@section('container')
    <div id="app">
        <user-index
                v-bind:edit-url="'/superadministrator/user/{id}/edit'"
                v-bind:load-user-url="'/api/v1/admin/user'"
                v-bind:delete-url="'/api/v1/admin/user/{id}'"
                v-bind:create-user-url="'/superadministrator/user/create'">
        </user-index>
    </div>

@endsection
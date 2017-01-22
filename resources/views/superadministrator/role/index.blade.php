@extends('layouts.container')

@section('container')
    <div id="app">
        <role-index
                v-bind:create-role-url="'/superadministrator/role/create'"
                v-bind:edit-role-prefix="'/superadministrator/role/'"
                v-bind:edit-role-postfix="'/edit'"
                v-bind:load-roles-url="'/api/v1/admin/role/'"
                v-bind:delete-role-url="'/api/v1/admin/role/'"
        ></role-index>

    </div>

@endsection
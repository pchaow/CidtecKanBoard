@extends('layouts.container')

@section('container')
    <div id="app">
        <role-index

                v-bind:create-url="'/superadministrator/role/create'"
                v-bind:edit-url="'/superadministrator/role/{id}/edit'"
                v-bind:load-url="'/api/v1/admin/role/'"
                v-bind:delete-url="'/api/v1/admin/role/'"
        ></role-index>

    </div>

@endsection
@extends('layouts.container')

@section('container')
    <div id="app">
        <user-index
                v-bind:edit-prefix="'/superadministrator/user/'"
                v-bind:edit-postfix="'/edit'"
                v-bind:load-user-url="'/api/v1/admin/user'"
                v-bind:delete-user-prefix="'/api/v1/admin/user/'">
        </user-index>
    </div>

@endsection
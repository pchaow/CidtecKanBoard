@extends('layouts.container')

@section('container')
    <div id="app">
        <user-create

                v-bind:save-url="'/api/v1/admin/user'"
                v-bind:success-url="'/superadministrator/user'"
                v-bind:load-roles-url="'/api/v1/admin/role'"
        </user-create>
    </div>
@endsection
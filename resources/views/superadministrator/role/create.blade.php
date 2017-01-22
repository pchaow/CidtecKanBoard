@extends('layouts.container')

@section('container')
    <div id="app">
        <role-create
                v-bind:success-url="'/superadministrator/role'"
                v-bind:save-role-url="'/api/v1/admin/role'"
        ></role-create>
    </div>

@endsection

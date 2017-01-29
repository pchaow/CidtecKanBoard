@extends('layouts.container')

@section('container')
    <div id="app">
        <role-edit
                v-bind:save-url="'/api/v1/admin/role/{{$roleId or 0}}'"
                v-bind:load-url="'/api/v1/admin/role/{{$roleId or 0}}'"
                v-bind:success-url="'/superadministrator/role'"
                v-bind:role-id="{{$roleId or 0}}"></role-edit>
    </div>

@endsection
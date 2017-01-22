@extends('layouts.container')

@section('container')
    <div id="app">
        <role-edit
                v-bind:save-prefix="'/api/v1/admin/role/'"
                v-bind:save-postfix="''"
                v-bind:load-prefix="'/api/v1/admin/role/'"
                v-bind:load-postfix="''"
                v-bind:success-url="'/superadministrator/role'"
                v-bind:role-id="{{$roleId or 0}}"></role-edit>
    </div>

@endsection
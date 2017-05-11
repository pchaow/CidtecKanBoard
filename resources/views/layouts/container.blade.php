@extends('layouts.app')

@section('container')

    <div class="user-header">
        @yield('header')
    </div>

    <div>
        <div class="container" style="margin-top: 22px;">
            @yield('content')
        </div>
    </div>

@endsection

@extends('layouts.app')

@section('container')

    <div class="user-header">

        @yield('header')

    </div>

    <div>
        <div class="container">
            @yield('content')
        </div>
    </div>

@endsection

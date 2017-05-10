@extends('layouts.app')

@section('container')

    <div class="user-header">

        <div class="container header">
            @yield('header')
        </div>
    </div>

    <div>
        <div class="container">
            @yield('content')
        </div>
    </div>

@endsection

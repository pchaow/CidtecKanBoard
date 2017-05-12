@extends('layouts.app')

@section('container')

    <div class="user-header">
        @yield('header')
    </div>

    <div>
        <div class="container{{$fluid or ''}}" style="margin-top: 22px;">
            @yield('content')
        </div>
    </div>

@endsection

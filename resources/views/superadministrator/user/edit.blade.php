@extends('layouts.app')

@section('content')
   <user-edit v-bind:user-id="{{$userId or 0}}"></user-edit>
@endsection
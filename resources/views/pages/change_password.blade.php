@extends('layouts.app')

@section('content')
    @include('partials.profile', ['user' => $user])
    @include('partials.changePassword')
    @include('partials.profileNavClose')
@endsection
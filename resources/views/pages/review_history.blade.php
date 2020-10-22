@extends('layouts.app')

@section('content')
    @include('partials.profile', ['user' => $user])
    @include('partials.reviewHistory', ['user' => $user, 'products' => $products])
    @include('partials.profileNavClose')
@endsection
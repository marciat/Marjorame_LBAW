@extends('layouts.app')

@section('content')
    @include('partials.profile', ['user' => $user])
    @include('partials.publicProfile', ['user' => $user, 'buyer' => $buyer, 'country' => $country])
    @include('partials.profileNavClose')
@endsection
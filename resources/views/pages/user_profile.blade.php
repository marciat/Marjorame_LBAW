@extends('layouts.app')

@section('content')
    @include('partials.profile', ['user' => $user])
    @include('partials.userProfile', ['user' => $user, 'buyer' => $buyer, 'country' => $country, 'address' => $address])
    @include('partials.profileNavClose')
@endsection
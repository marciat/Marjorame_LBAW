@extends('layouts.app')

@section('content')
    @include('partials.profile', ['user' => $user])
    @include('partials.purchaseHistory', ['user' => $user, 'purchases' => $purchases])
    @include('partials.profileNavClose')
@endsection
@extends('layouts.app')

@section('content')
    @include('partials.checkout', ['user' => $user, 'buyer' => $buyer, 'country' => $country, 'address' => $address, 'city' => $city, 'products' => $products, 'price' => $price])
@endsection


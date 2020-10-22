@extends('layouts.app')

@section('content')
    @include('partials.cart', ['cart_prods' => $cart_prods])
@endsection
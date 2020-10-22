@extends('layouts.app')

@section('content')
    @include('partials.fashion', [ 'products' => $products, 'page_title' => $page_title])
@endsection
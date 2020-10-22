@extends('layouts.app')

@section('content')
    @include('partials.decor', [ 'products' => $products, 'page_title' => $page_title])
@endsection
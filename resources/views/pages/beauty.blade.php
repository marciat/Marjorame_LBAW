@extends('layouts.app')

@section('content')
    @include('partials.beauty', [ 'products' => $products, 'page_title' => $page_title])
@endsection
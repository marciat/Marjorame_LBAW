@extends('layouts.app')

@section('content')
    @include('partials.adminOptions', ['users' => $users])
@endsection
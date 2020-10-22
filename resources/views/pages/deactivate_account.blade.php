@extends('layouts.app')

<!-- Modal for disable account  -->
<div class="modal fade" id="disable_account_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    @include('partials.modal', [ 'title' => 'Disable account', 'description' => 'Your information will remain in our system allowing you to reactive your account in the future.',
                'url' => 'deactivate_account' ])
</div>


<!-- Modal for disable account  -->
<div class="modal fade" id="delete_account_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    @include('partials.modal', [ 'title' => 'Delete account', 'description' =>  'Once you delete your account, there is no going back. Please be certain.' ,
                'url' => 'delete_account'])
</div>

@section('content')
    @include('partials.profile', ['user' => $user])
    @include('partials.deactivateAccount')
    @include('partials.profileNavClose')
@endsection
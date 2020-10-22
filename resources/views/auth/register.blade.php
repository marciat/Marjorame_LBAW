@extends('layouts.app')

@section('content')

<form class="form-signin" method="POST" action="{{ route('register') }}">

  {{ csrf_field() }}
  <fieldset>
    <label for="RegisterUsername" class="sr-only">Username</label>
    <input id="RegisterUsername" type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Username" required autofocus>
    @if ($errors->has('usernameReg'))
    <span class="error">
      {{ $errors->first('usernameReg') }}
    </span>
    @endif

    <div class="row">
      <div class="col-md-6">
        <label for="inputFName" class="sr-only">First Name</label>
        <input type="text" id="inputFName" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="First Name" required>
        @if ($errors->has('first_name'))
        <span class="error">
          {{ $errors->first('first_name') }}
        </span>
        @endif
      </div>
      <div class="col-md-6">
        <label for="inputLName" class="sr-only">Last Name</label>
        <input type="text" id="inputLFName" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
        @if ($errors->has('last_name'))
        <span class="error">
          {{ $errors->first('last_name') }}
        </span>
        @endif
      </div>
    </div>

    <label for="registerEmail" class="sr-only">Email</label>
    <input type="email" id="registerEmail" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
    @if ($errors->has('emailReg'))
    <span class="error">
      {{ $errors->first('emailReg') }}
    </span>
    @endif

    <label for="registerDate" class="sr-only">Date of Birth</label>
    <input type="date" id="registerDate" class="form-control" name="birthdate" value="{{ old('birthdate') }}" placeholder="Date of Birth" required>
    @if ($errors->has('birthdate'))
    <span class="error">
      {{ $errors->first('birthdate') }}
    </span>
    @endif


    <label for="registerPassword" class="sr-only">Password</label>
    <input type="password" id="registerPassword" class="form-control" name="password" placeholder="Password" required>
    @if ($errors->has('passwordReg'))
    <span class="error">
      {{ $errors->first('passwordReg') }}
    </span>
    @endif


    <label for="registerPassword1" class="sr-only">Confirm Password</label>
    <input type="password" id="registerPassword1" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>

    <label class="form-check-label" for="acceptTerms">I accept the terms of service and am at least 16 years of
      age</label>
    <input class="form-check-input" type="checkbox" value="" id="acceptTerms" required>

  <button id="Register" class="sign_btn">Register</button>
  <div class="google-btn">
    <div class="google-icon-wrapper">
      <img class="google-icon" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google" />
    </div>
  </fieldset>
</form>
@endsection
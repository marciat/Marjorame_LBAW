@extends('layouts.app')

@section('content')
<form class="form-signin" method="POST" action="{{ route('login') }}">
  {{ csrf_field() }}

  <fieldset>
    <label for="SignInName" class="sr-only">Email</label>
    <input type="text" id="SignInName" name="login" class="form-control" value="{{old('username') ?: old('email')}}" autocomplete="email" placeholder="Email or Username" required autofocus>
    @if ($errors->has('email') || $errors->has('username'))
    <span class="error">
      {{ $errors->first('email') ?: $errors->first('username') }}
    </span>
    @endif

    <label for="SignInputPassword" class="sr-only">Password</label>
    <input type="password" id="SignInputPassword" name="password" class="form-control" placeholder="Password" required>
    @if ($errors->has('password'))
    <span class="error">
      {{ $errors->first('password') }}
    </span>
    @endif


    <p id="forgot_password">Forgot your password?</p>

  <button id="Sign_in" class="sign_btn" type="submit">Sign in</button>
  <div class="google-btn">
    <div class="google-icon-wrapper">
      <img class="google-icon" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google" />
    </div>
  </fieldset>

</form>
@endsection
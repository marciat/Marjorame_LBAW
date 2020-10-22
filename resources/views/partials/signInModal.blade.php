<!-- Sign in Modal -->
<div class="modal fade" id="SignInModal" tabindex="-1" role="dialog" aria-labelledby="SignInModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h2 class="modal-title text-center" id="SignInModal">Marjorame</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form class="form-signin" method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}

          <fieldset>
            <div class="form-group">
              <label for="SignInName" class="form-check-label">Email/Username</label>
              <input type="text" id="SignInName" name="login" class="form-control" value="{{old('username') ?: old('email')}}" autocomplete="email" required autofocus>
              @if ($errors->has('email') || $errors->has('username'))
              <span class="error">
                {{ $errors->first('email') ?: $errors->first('username') }}
              </span>
              @endif
            </div>

            <div class="form-group">
              <label for="SignInputPassword" class="form-check-label">Password</label>
              <input type="password" id="SignInputPassword" name="password" class="form-control" required>
              @if ($errors->has('password'))
              <span class="error">
                {{ $errors->first('password') }}
              </span>
              @endif
            </div>

            @if(!empty(Session::get('login_error')) && Session::get('login_error') == 'not_active')
              <span class="error">
                The account you have attempted to access is not active
              </span>
            @elseif(!empty(Session::get('login_error')) && Session::get('login_error') == 'banned')
              <span class="error">
                The account you have attempted to access has been banned
              </span>
            @endif


            <p id="forgot_password">Forgot your password?</p>

          <button id="Sign_in" class="sign_btn" type="submit">Sign in</button>
          <div class="google-btn">
            <div class="google-icon-wrapper">
              <img alt="Google" class="google-icon" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" />
            </div>
          </fieldset>
        </form>
      </div>

    </div>
  </div>
</div> <!-- modal fade -->
<!-- Register Modal -->
<div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModal"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center">Marjorame</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form class="form-signin" method="POST" action="{{ route('register') }}">

          {{ csrf_field() }}

          <div class="form-group">
            <label for="RegisterUsername" class="form-check-label">Username</label>
            <input id="RegisterUsername" type="text" name="register_username" class="form-control"
              value="{{ old('register_username') }}" required autofocus>
            @if ($errors->has('register_username'))
            <span class="error">
              {{ $errors->first('register_username') }}
            </span>
            @endif
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputFName" class="form-check-label">First Name</label>
                <input type="text" id="inputFName" name="first_name" class="form-control"
                  value="{{ old('first_name') }}" required>
                @if ($errors->has('first_name'))
                <span class="error">
                  {{ $errors->first('first_name') }}
                </span>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputLName" class="form-check-label">Last Name</label>
                <input type="text" id="inputLFName" class="form-control" name="last_name" value="{{ old('last_name') }}"
                  required>
                @if ($errors->has('last_name'))
                <span class="error">
                  {{ $errors->first('last_name') }}
                </span>
                @endif
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="registerEmail" class="form-check-label">Email</label>
            <input type="email" id="registerEmail" class="form-control" name="register_email"
              value="{{ old('register_email') }}" required>
            @if ($errors->has('register_email'))
            <span class="error">
              {{ $errors->first('register_email') }}
            </span>
            @endif
          </div>

          <div class="form-group">
            <label for="registerDate" class="form-check-label">Date of Birth</label>
            <input type="date" id="registerDate" class="form-control" name="birthdate" value="{{ old('birthdate') }}"
              required>
            @if ($errors->has('birthdate'))
            <span class="error">
              {{ $errors->first('birthdate') }}
            </span>
            @endif
          </div>


          <div class="form-group">
            <label for="registerPassword" class="form-check-label">Password</label>
            <input type="password" id="registerPassword" class="form-control" name="register_password" required>
            @if ($errors->has('register_password'))
            <span class="error">
              {{ $errors->first('register_password') }}
            </span>
            @endif
          </div>


          <div class="form-group">
            <label for="registerPassword1" class="form-check-label">Confirm Password</label>
            <input type="password" id="registerPassword1" class="form-control" name="register_password_confirmation"
              required>
          </div>

          <label class="form-check-label" for="acceptTerms">I accept the terms of service and am at least 16 years of
            age</label>
          <input class="form-check-input" type="checkbox" value="" id="acceptTerms" required>

          <button id="Register" class="sign_btn">Register</button>
          <div class="google-btn">
            <div class="google-icon-wrapper">
              <img alt="Google"
                class="google-icon"
                src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" />
            </div>
            <p class="btn-text"><b>Sign in with Google</b></p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<main role="main" class="col-12 col-md-10 profile_content">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Change Password</h1>
  </div>
  <div id="change_password" class="d-inline-flex p-2">
    <form method="POST" class="form-signin" action="{{ route('change_password') }}">
      {{ csrf_field() }}

      <fieldset>
        <div class="form-group">
          <label for="current-password" class="form-check-label">Current Password</label>
          <input type="password" id="current-password" name="current-password" class="form-control" required>
          @if (session()->has('password-error'))
          <span class="error">
            {{ session()->get('password-error') }}
          </span>
          @endif
        </div>

        <div class="form-group">
          <label for="new-password" class="form-check-label">New Password</label>
          <input type="password" id="new-password" name="new-password" class="form-control" required>
          @if ($errors->has('new-password'))
          <span class="error">
            {{ $errors->first('new-password') }}
          </span>
          @endif
          @if (session()->has('repeated-password'))
          <span class="error">
            {{ session()->get('repeated-password') }}
          </span>
          @endif
        </div>

        <div class="form-group">
          <label for="new-password-confirm" class="form-check-label">Confirm Password</label>
          <input type="password" id="new-password-confirm" name="new-password_confirmation" class="form-control" required>
        </div>

        <p>For you security, make sure it's at least 8 characters including a number and a letter.</p>

        @if (session()->has('success'))
          <span class="success">
            {{ session()->get('success') }}
          </span>
        @endif
      </fieldset>

      <button type="submit" class="submit_action_btn" id="confirm_password_btn">Confirm Change</button>
    </form>
  </div>
</main>

</div>
<main role="main" class="col-12 col-md-10 profile_content edit_profile">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User Profile</h1>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" class="needs-validation" action="{{ route('edit_profile') }}">
          {{ csrf_field() }}

          <fieldset>
            <legend><h4>General Information:</h4> </legend>
            <div class="row">
              <div class="col-md-3 col-6 mb-3">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user->first_name ?>" placeholder="" required>
                @if ($errors->has('first_name'))
                  <span class="error">
                    {{ $errors->first('first_name') }}
                  </span>
                @endif
              </div>
              <div class="col-md-3 col-6 mb-3">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user->last_name ?>" placeholder="" required>
                @if ($errors->has('last_name'))
                  <span class="error">
                    {{ $errors->first('last_name') }}
                  </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col-md-3 col-6 mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user->username ?>" placeholder="" disabled>
                @if ($errors->has('username'))
                  <span class="error">
                    {{ $errors->first('username') }}
                  </span>
                @endif
              </div>
              <div class="col-md-3 col-6 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" id="country" name="country" required>
                  <option value="">Choose...</option>
                  <?php if (strcmp($country->name, 'Portugal') == 0) { ?>
                    <option value='Portugal' selected>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else  if (strcmp($country->name, 'Italy') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy' selected>Italy</option>

                  <?php } else if (strcmp($country->name, 'Germany') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany' selected>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else if (strcmp($country->name, 'Netherlands') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands' selected>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else if (strcmp($country->name, 'Spain') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain' selected>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else if (strcmp($country->name, 'France') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France' selected>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php }  ?>
                </select>
                @if ($errors->has('country'))
                  <span class="error">
                    {{ $errors->first('country') }}
                  </span>
                @endif
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend><h4 class="mb-3 mt-5">Contact Information:</h4> </legend>
            <div class="mb-3">
              <label for="email">Email </label>
              <input type="email" class="form-control" id="user_email" name="user_email" value="<?= $user->email ?>" placeholder="you@example.com" disabled>
              @if ($errors->has('user_email'))
                <span class="error">
                    {{ $errors->first('user_email') }}
                  </span>
              @endif
            </div>
            <div class="mb-3">
              <label for="user_phone">Phone Number</label>
              <input type="phone" class="form-control" id="user_phone" name="user_phone" value="<?= $buyer->phone_number ?>" placeholder="" required>
              @if ($errors->has('user_phone'))
                <span class="error">
                    {{ $errors->first('user_phone') }}
                  </span>
              @endif
            </div>

            @if (session()->has('success_profile'))
              <span class="success">
                {{ session()->get('success_profile') }}
              </span>
            @endif
            </fieldset>

            <hr class="mb-3">
            <button class="edit_profile_btn" type="submit">Update Profile</button>

        </form>

        <form method="POST" class="needs-validation" action="{{ route('edit_profile_address') }}">
          {{ csrf_field() }}
          <fieldset>
            <legend><h4 class="mb-3 mt-5">Shipping Details:</h4> </legend>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="vat_number">VAT</label>
                <input type="number" class="form-control" id="vat_number" name="vat_number" placeholder="" value="<?= $buyer->vat ?>">
                @if ($errors->has('vat_number'))
                  <span class="error">
                    {{ $errors->first('vat_number') }}
                  </span>
                @endif
              </div>

              <div class="col-md-4 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" id="country_address" name="country_address" required>
                  <option value="">Choose...</option>
                  <?php if (strcmp($country->name, 'Portugal') == 0) { ?>
                    <option value='Portugal' selected>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else  if (strcmp($country->name, 'Italy') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy' selected>Italy</option>

                  <?php } else if (strcmp($country->name, 'Germany') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany' selected>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else if (strcmp($country->name, 'Netherlands') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands' selected>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else if (strcmp($country->name, 'Spain') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain' selected>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else if (strcmp($country->name, 'France') == 0) { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France' selected>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php } else { ?>
                    <option value='Portugal'>Portugal</option>
                    <option value='Germany'>Germany</option>
                    <option value='Netherlands'>Netherlands</option>
                    <option value='France'>France</option>
                    <option value='Spain'>Spain</option>
                    <option value='Italy'>Italy</option>

                  <?php }  ?>
                </select>
                @if ($errors->has('country_address'))
                  <span class="error">
                    {{ $errors->first('country_address') }}
                  </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col-md-7 mb-3">
                <label for="user_address">Address</label>
                <input type="text" class="form-control" id="user_address" name="user_address" placeholder="" value="<?= $address->street ?>" required>
                @if ($errors->has('user_address'))
                  <span class="error">
                    {{ $errors->first('user_address') }}
                  </span>
                @endif
              </div>

              <div class="col-md-2 mb-3">
                <label for="user_residence_number">Residence number</label>
                <input type="text" class="form-control" id="user_residence_number " name="user_residence_number" placeholder="" value="<?= $address->residence_number ?>" required>
                @if ($errors->has('user_residence_number'))
                  <span class="error">
                    {{ $errors->first('user_residence_number') }}
                  </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="address2">Additional information</span></label>
                <input type="text" class="form-control" name="address2" id="address2" placeholder="" value="<?= $address->additional_information ?>">
                @if ($errors->has('address2'))
                  <span class="error">
                    {{ $errors->first('address2') }}
                  </span>
                @endif
              </div>

              <div class="col-md-3 mb-3">
                <label for="city">City</label>
                <input type="text" class="form-control" name="user_city" id="user_city" placeholder="" value="<?= $city->name ?>" required>
                @if ($errors->has('user_city'))
                  <span class="error">
                    {{ $errors->first('user_city') }}
                  </span>
                @endif
              </div>

              <div class="col-md-3 mb-3">
                <label for="user_zip">Zip Code</label>
                <input type="text" class="form-control" name="user_zip" id="user_zip" placeholder="" value="<?= $address->zip_code ?>" required>
                @if ($errors->has('user_zip'))
                  <span class="error">
                    {{ $errors->first('user_zip') }}
                  </span>
                @endif
              </div>
            </div>

            @if (session()->has('success_address'))
              <span class="success">
                {{ session()->get('success_address') }}
              </span>
            @endif
          </fieldset>
          <hr class="mb-3">
          <button class="edit_profile_btn" type="submit">Update Address</button>
        </form>
      </div>
    </div>
  </div>

</main>
</div>
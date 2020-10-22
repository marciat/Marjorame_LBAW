<div class="container-fluid my-container fixed">
  <div class="row">
    <nav class="col-12 col-md-2 navbar-expand-md navbar-light sidebar-md no_padding">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenavCollapse" aria-controls="sidenavCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="sidenavCollapse">
        <div class="sidebar-sticky my-container sidebar_color">
          <img alt="user image" src="{{ Storage::url($user->getPhoto()) }}" alt="Example" class="profile_image">
            <h1 class="profile_sidebar_name">{{$user->username}}</h1>
            <ul class="nav flex-column">
              @if (Auth::check() && Auth::user()->id == $user->id)
              <li class="nav-item">
                <a class="nav-link profile_buttons" href="/user/{{$user->id}}/edit_profile">
                  <h6>User Profile </h6>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile_buttons" href="/change_password/{{$user->id}}">
                  <h6>Change Password</h6>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link profile_buttons" href="/user/{{$user->id}}">
                  <h6>View Public Profile</h6>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile_buttons" href="/user/{{$user->id}}/review_history">
                  <h6>Review History</h6>
                </a>
              </li>
              @if ((Auth::check() && Auth::user()->id == $user->id) || (Auth::check() && Auth::user()->admin))
              <li class="nav-item">
                <a class="nav-link profile_buttons" href="/user/{{$user->id}}/purchase_history">
                  <h6>Purchase History</h6>
                </a>
              </li>
              @endif
              @if ((Auth::check() && Auth::user()->id == $user->id))
              <li class="nav-item">
                <a class="nav-link profile_buttons" href="/user/{{$user->id}}/favorites">
                  <h6>Favorites</h6>
                </a>
              </li>
              @else
              <li class="nav-item">
                <a class="nav-link profile_buttons last_profile_button" href="/user/{{$user->id}}/favorites">
                  <h6>Favorites</h6>
                </a>
              </li>
              @endif
              @if (Auth::check() && Auth::user()->id == $user->id)
              <li class="nav-item">
                <a class="nav-link profile_buttons last_profile_button" href="/user/{{$user->id}}/deactivate_account">
                  <h6>Deactivate Account</h6>
                </a>
              </li>
              @endif
            </ul>


        </div>
      </div>
    </nav>
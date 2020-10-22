<nav class="navbar navbar-expand-md navbar-dark fixed-top bar_background">
    <a class="navbar-brand" href="/">Marjorame <i class="fas fa-seedling"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">

            @if (Route::currentRouteName() == 'products/Fashion'
            || Route::currentRouteName() == '/products/Fashion/Bags and Wallets/Backpacks'
            || Route::currentRouteName() == '/products/Fashion/Bags and Wallets/Shoulder Bags'
            || Route::currentRouteName() == '/products/Fashion/Bags and Wallets/Tote Bags'
            || Route::currentRouteName() == '/products/Fashion/Bags and Wallets/Wallets'
            || Route::currentRouteName() == '/products/Fashion/Clothing/Bottoms'
            || Route::currentRouteName() == '/products/Fashion/Clothing/Tops'
            || Route::currentRouteName() == '/products/Fashion/Jewelry/Bracelets'
            || Route::currentRouteName() == '/products/Fashion/Jewelry/Earrings'
            || Route::currentRouteName() == '/products/Fashion/Jewelry/Necklaces'
            || Route::currentRouteName() == '/products/Fashion/Jewelry/Rings'
            || Route::currentRouteName() == '/products/Fashion/Winter Accessories/Beanies'
            || Route::currentRouteName() == '/products/Fashion/Winter Accessories/Gloves'
            || Route::currentRouteName() == '/products/Fashion/Winter Accessories/Scarves'
            || Route::currentRouteName() == '/products/Fashion/Belts'
            || Route::currentRouteName() == '/products/Fashion/Socks'
            || Route::currentRouteName() == '/products/Fashion/Watches'
            )
            <li class="nav-item active">
                <a class="nav-link" href="/products/Fashion">FASHION<span class="sr-only">(current)</span></a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/products/Fashion">FASHION</a>
            </li>
            @endif


            @if (Route::currentRouteName() == 'products/Beauty'
            || Route::currentRouteName() == '/products/Beauty/Makeup/Accessories'
            || Route::currentRouteName() == '/products/Beauty/Makeup/Eyes'
            || Route::currentRouteName() == '/products/Beauty/Makeup/Face'
            || Route::currentRouteName() == '/products/Beauty/Makeup/Lips'
            || Route::currentRouteName() == '/products/Beauty/Fragrances'
            || Route::currentRouteName() == '/products/Beauty/Hygiene' )
            <li class="nav-item active">
                <a class="nav-link" href="/products/Beauty">BEAUTY<span class="sr-only">(current)</span></a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/products/Beauty">BEAUTY</a>
            </li>
            @endif

            @if (Route::currentRouteName() == 'products/Decor'
            || Route::currentRouteName() == '/products/Decor/Bathroom'
            || Route::currentRouteName() == '/products/Decor/Bedroom'
            || Route::currentRouteName() == '/products/Decor/Kitchen'
            || Route::currentRouteName() == '/products/Decor/Living Room'
            || Route::currentRouteName() == '/products/Decor/Outdoors' )
            <li class="nav-item active">
                <a class="nav-link" href="/products/Decor">DECOR<span class="sr-only">(current)</span></a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/products/Decor">DECOR</a>
            </li>
            @endif
        </ul>

        <form action="/search" method="get" role="search" class="form-inline my-2 my-lg-0 align-self-stretch">
            {{ csrf_field() }}
            <label class="sr-only" for="search_bar">Search Bar</label>
            <input class="form-control mr-sm-2" id="search_bar" type="text" placeholder="Search products" aria-label="Search" name="search">
            <i class="fas fa-search p-2 visible"><button type="submit" class="btn btn-light btn-sm invisible"></button></i>
        </form>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <div class="btn-group">
                    <i class="fas fa-user p-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                    <div class="dropdown-menu dropdown-menu-right" id="dropdownOptions">
                        @if (Auth::check() && !Auth::user()->admin)
                        <!-- check if login and not admin   -->
                        <a class="dropdown-item" href="/user/{{Auth::user()->id}}"><i class="fas fa-user"></i>My
                            Profile</a>
                        <a class="dropdown-item" href="/user/{{Auth::user()->id}}/favorites"><i class="fas fa-heart"></i>Favorites</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            {{ csrf_field() }}
                            <button class="dropdown-item" id="logout" type="submit"><i class="fas fa-door-open"></i>Log
                                Out
                            </button>
                        </form>
                        @elseif (Auth::check() && Auth::user()->admin)
                        <!-- check if admin -->
                        <a class="dropdown-item" href="/add_product">Add Product</a>
                        <a class="dropdown-item" href="/control_users">Manage users</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            {{ csrf_field() }}
                            <button class="dropdown-item" id="logout" type="submit"><i class="fas fa-door-open"></i>Log
                                Out
                            </button>
                        </form>
                        @else
                        <a href="#" class="dropdown-item" type="button" data-toggle="modal" data-target="#SignInModal"><i class="fas fa-user"></i></i> Sign in</a>
                        <a class="dropdown-item" type="button" data-toggle="modal" data-target="#RegisterModal"><i class="fas fa-seedling"></i>Join Marjorame</a>
                        @endif
                    </div>
                </div>
            </li>
            <li class="nav-item">
                @if (!Auth::check())
                <a href="/cart" id="cart-button"> <i class="fas fa-shopping-bag p-2"></i> </a>
                @elseif (Auth::check() && !Auth::user()->admin)
                <a href="/cart" id="cart-button"> <i class="fas fa-shopping-bag p-2"></i> </a>
                @endif
            </li>
        </ul>

        @if(!empty(Session::get('error_code')))
            @if(Session::get('error_code') == 'bad_login')
            <script>
                $(function() {
                    $('#SignInModal').modal('show');
                });
            </script>
            @elseif(Session::get('error_code') == 'bad_register')
            <script>
                $(function() {
                    $('#RegisterModal').modal('show');
                });
            </script>
            @elseif(Session::get('error_code') == 'bad_deactivate')
                <script>
                    $(function() {
                        $('#disable_account_modal').modal('show');
                    });
                </script>
            @elseif(Session::get('error_code') == 'bad_delete')
                <script>
                    $(function() {
                        $('#delete_account_modal').modal('show');
                    });
                </script>
            @endif
        @endif
    </div>
</nav>

@include('partials.signInModal')
@include('partials.registerModal')
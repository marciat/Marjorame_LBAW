<!-- divide in two halves -->
<div class="row align-items-center homepage-buttons">
  <div class="col-md-5 order-md-5 order-7">
    <div class="column justify-content-center">

      <div class="row  justify-content-center">
        <button onclick="window.location.href = '/products/Fashion';" class="home_button home_button_first" type="submit">Fashion</button>
      </div>

      <div class="row  justify-content-center">
        <button onclick="window.location.href = 'products/Beauty';" class="home_button home_button_default" type="submit">Beauty</button>
      </div>

      <div class="row justify-content-center">
        <button onclick="window.location.href = 'products/Decor';" class="home_button home_button_default" id="last_home_button" type="submit">Decor</button>
      </div>

    </div> <!-- column -->
  </div><!-- /.col-lg-6 -->
  <div class="col-md-7 order-md-7 order-1 px-0">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">

      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <img alt="soap" class="bd-placeholder-img" width="100%" height="100%" src="https://images.unsplash.com/photo-1508759073847-9ca702cec7d2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
          <div class="container">
            <div class="carousel-caption text-left">
              <h1>Natural Beauty</h1>
              <p style="color:#3a3a3a">Our soap is handmade with carefully selected, natural, plant-based ingredients.
              </p>
              <p><a class="carousel_button" href="/product/6" role="button">Check it out</a></p>
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <img alt="winter accessory" class="bd-placeholder-img" width="100%" height="100%" src="https://images.unsplash.com/photo-1574243840369-426f9187e795?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
          <div class="container">
            <div class="carousel-caption">
              <h1>Winter Collection</h1>
              <p style="color:#3a3a3a">Check out our new winter items, perfect to make you feel cozy in cold weather.
              </p>
              <p><a class="carousel_button" href="/products/Fashion/Winter Accessories" role="button">Check it out</a></p>
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <img alt="jewelry image" class="bd-placeholder-img" width="100%" height="100%" src="https://images.unsplash.com/photo-1457040931721-53ca161dab33?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
          <div class="container">
            <div class="carousel-caption text-right">
              <h1>Elegant accessories</h1>
              <p style="color:#3a3a3a">Give your looks an elegant touch with our wide selection of jewelry.</p>
              <p><a class="carousel_button" href="/products/Fashion/Jewelry" role="button">Shop Jewelry</a></p>
            </div>
          </div>
        </div>
      </div>

      <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>

  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
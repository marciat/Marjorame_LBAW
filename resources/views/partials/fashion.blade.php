<main role="main">

  <div class="row">
    <div class="col-md-2 categories">
      <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#filters_collapse" aria-controls="filterCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="filters_collapse">
        <ul>
          <li><span class="caret">Bags & Wallets</span>
            <ul class="nested">
              <a href="/products/Fashion/Bags and Wallets/Backpacks">
                <li>Backpacks</li>
              </a>
              <a href="/products/Fashion/Bags and Wallets/Shoulder Bags">
                <li>Shoulder Bags</li>
              </a>
              <a href="/products/Fashion/Bags and Wallets/Tote Bags">
                <li>Tote Bags</li>
              </a>
              <a href="/products/Fashion/Bags and Wallets/Wallets">
                <li>Wallets</li>
              </a>
            </ul>
          </li>
          <li><span class="caret">Clothing</span>
            <ul class="nested">
              <a href="/products/Fashion/Clothing/Bottoms">
                <li>Bottoms</li>
              </a>
              <a href="/products/Fashion/Clothing/Tops">
                <li>Tops</li>
              </a>
            </ul>
          </li>
          <li><span class="caret">Jewelry</span>
            <ul class="nested">
              <a href="/products/Fashion/Jewelry/Bracelets">
                <li>Bracelets</li>
              </a>
              <a href="/products/Fashion/Jewelry/Earrings">
                <li>Earrings</li>
              </a>
              <a href="/products/Fashion/Jewelry/Necklaces">
                <li>Necklaces</li>
              </a>
              <a href="/products/Fashion/Jewelry/Rings">
                <li>Rings</li>
              </a>
            </ul>
          </li>
          <li><span class="caret">Winter Accessories</span>
            <ul class="nested">
              <a href="/products/Fashion/Winter Accessories/Beanies">
                <li>Beanies</li>
              </a>
              <a href="/products/Fashion/Winter Accessories/Gloves">
                <li>Gloves</li>
              </a>
              <a href="/products/Fashion/Winter Accessories/Scarves">
                <li>Scarves</li>
              </a>
            </ul>
          </li>
          <a href="/products/Fashion/Belts">
            <li>Belts</li>
          </a>
          <a href="/products/Fashion/Socks">
            <li>Socks</li>
          </a>
          <a href="/products/Fashion/Watches">
            <li>Watches</li>
          </a>
        </ul>
        @include('partials.filters', [ 'category' => 'Fashion' ])
      </div>
    </div>
    <div class="col-md-10">
      @include('partials.productsGridHeader', [ 'page_title' => $page_title ])
      @if (count($products) > 0)
        @include('partials.listItems', [ 'products' => $products ])
      @else
        @include('partials.empty_product')
      @endif
    </div>
  </div> <!-- row -->

</main>
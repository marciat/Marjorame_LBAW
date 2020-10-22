<main role="main">

  <div class="row">
    <div class="col-md-2 categories">
      <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#filters_collapse" aria-controls="filterCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="filters_collapse">
        <ul>
          <li><span class="caret">Makeup</span>
            <ul class="nested">
              <a href="/products/Beauty/Makeup/Accessories">
                <li>Accessories</li>
              </a>
              <a href="/products/Beauty/Makeup/Eyes">
                <li>Eyes</li>
              </a>
              <a href="/products/Beauty/Makeup/Face">
                <li>Face</li>
              </a>
              <a href="/products/Beauty/Makeup/Lips">
                <li>Lips</li>
              </a>
            </ul>
          </li>
          <a href="/products/Beauty/Fragrances">
            <li><span>Fragrances</span></li>
          </a>
          <a href="/products/Beauty/Hygiene">
            <li><span>Hygiene</span></li>
          </a>
        </ul>
        @include('partials.filters', [ 'category' => 'Beauty' ])
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
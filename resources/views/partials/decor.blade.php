<main role="main">

  <div class="row">
    <div class="col-md-2 categories">
      <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#filters_collapse" aria-controls="filterCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="filters_collapse">
        <ul>
          <a href="/products/Decor/Bathroom"><li><span>Bathroom</span></li></a>
          <a href="/products/Decor/Bedroom"><li><span>Bedroom</span></li></a>
          <a href="/products/Decor/Kitchen"><li><span>Kitchen</span></li></a>
          <a href="/products/Decor/Living Room"><li><span>Living Room</span></li></a>
          <a href="/products/Decor/Outdoors"><li><span>Outdoor</span></li></a>
        </ul>
        @include('partials.filters', [ 'category' => 'Decor' ])
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
<section class="products_grid">
  @each('partials.product_icon', $products, 'product')
</section>
<div class="row justify-content-center">
  <nav>
    {{$products->links()}}
  </nav>
</div>
</div>

</div>
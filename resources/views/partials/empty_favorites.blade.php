@if(!Auth::User()->admin)
  <div class="row justify-content-center py-3">
    <h3>It appears no products have been favorited! Consider checking out our products:</h3>
  </div>
  <div class="row justify-content-center py-1">
    <h5><a href="/products/Fashion">Fashion</a></h5>
  </div>
  <div class="row justify-content-center py-1">
    <h5><a href="/products/Decor">Decor</a></h5>
  </div>
  <div class="row justify-content-center py-1">
    <h5><a href="/products/Beauty">Beauty</a></h5>
  </div>
@else
  <div class="row justify-content-center py-3">
    <h3>This user hasn't favorited any products</h3>
  </div>
@endif



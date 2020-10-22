<div class="col-md-10 col-12  profile_content">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{$user->first_name}}'s Favorites</h1>
  </div>
  @if (count($products) > 0)
    @include('partials.listItems', [ 'products' => $products ])
  @else
    @include('partials.empty_favorites')
  @endif
</div>
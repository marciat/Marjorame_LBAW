<main role="main" class="col-12 col-md-10 profile_content">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom ">
    <h1 class="h2"><?=$user->first_name?>'s Purchase History</h1>
  </div>
  <div class="user_purchases">
    @each('partials.purchase', $purchases, 'purchase', 'partials.empty_purchase')
    <div class="row justify-content-center">
      <nav>
        {{$purchases->links()}}
      </nav>
    </div>
  </div>
</main>
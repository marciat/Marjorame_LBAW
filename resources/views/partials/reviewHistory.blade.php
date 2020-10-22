<main role="main" class="col-12 col-md-10 profile_content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom ">
        <h1 class="h2"><?= $user->first_name ?>'s Review History</h1>
    </div>

    <div class="all_reviews">
        @each('partials.review', $products, 'product', 'partials.empty_review')
    </div>
    <div class="row justify-content-center">
        <nav>
            {{$products->links()}}
        </nav>
    </div>
    </div>

</main>
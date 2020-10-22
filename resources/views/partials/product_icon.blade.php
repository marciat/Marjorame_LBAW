<div class="product_in_grid" data-id="<?= $product->id ?>">
    <a href="{{ url('product/'.$product->id) }}">
        <img alt="product" class="product_grid_image" src="{{ Storage::url($product->getPhoto($product->photo_id)) }}">
    </a>

    @if (!Auth::check())
    <i class="far fa-heart favorite_grid"></i>
    @else  
    <?php
    $found = false;
    if(Auth::User()->buyer){
        $favorites = Auth::User()->buyer->favorites;
        foreach ($favorites as $favorite) {
            if ($favorite->id == $product->id) {
                $found = true;
            }
        }
    }

    if ($found) { ?>
        <i class="fas fa-heart favorite_grid"></i>
    <?php } else {  ?>
        <i class="far fa-heart favorite_grid"></i>
    <?php }   ?>
    @endif

    <p class="product_grid_title"><?= $product->name ?></p>
    @for($i = 1; $i <= $product->rating; $i++)            <i class="fas fa-star"></i>

    @endfor
    @for($j = $product->rating + 1; $j <= 5; $j++)
        <i class="far fa-star"></i>
    @endfor

    <p class="product_grid_price">$ <?= $product->price ?></p>
</div>
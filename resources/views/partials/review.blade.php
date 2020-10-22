<div class="row my-2">
    <div class="col-md-2 col-10 my-2 mr-2">
        <a href="{{ url('product/'.$product->id) }}">
            <div class="review_stars">
                @for($i = 1; $i <= $product->pivot->rating; $i++)
                    <img alt="star" src="{{ Storage::url('public/images/star.png') }}">
                @endfor
                @for($j = $product->pivot->rating + 1; $j <= 5; $j++)
                    <img alt="empty star" src="{{ Storage::url('public/images/empty_star.png') }}">
                @endfor
            </div>
                {{$product->name}}
            <div class="row ml-0 review_date">
                <?= $product->pivot->date ?>
            </div>
        </a>
    </div>
    <div class="col-md-9 mt-md-3 ml-md-n4">
        <h5 class="review_title"><?= $product->pivot->title ?></h5>
        <p class="review_text"><?= $product->pivot->description ?></p>
    </div>
</div>
<hr class="mb-4">
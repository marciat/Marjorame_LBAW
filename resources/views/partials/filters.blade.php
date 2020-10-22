<!--
 Draws filters for all pages of list of items.
-->
<div class="container" id="filters">
  <form action="/filter/<?= $category ?>" method="post">
    @csrf
      <fieldset>
        <div class="price_slider" id="price_slider">
          <label for="price_input">Max. Price</label>
          <input id="price_input" type="range" name="price" min="0" max="100" oninput="rangevalue.value=value" />
          <output id="rangevalue" name="rangevalue" for="price">50</output>
        </div>
        <a class="filters_rating_title">Min. Rating</a><br>
        <fieldset class="star_rating">
          <input type="radio" id="star5" name="rating" value="5.0" required/><label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
          <input type="radio" id="star4" name="rating" value="4.0" /><label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
          <input type="radio" id="star3" name="rating" value="3.0" /><label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
          <input type="radio" id="star2" name="rating" value="2.0" /><label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
          <input type="radio" id="star1" name="rating" value="1.0" /><label for="star1" title="1 star"><i class="fas fa-star"></i></label>
        </fieldset>
        <button type="submit" id="apply_filters_btn" class="submit_action_btn">Apply</button>
      </fieldset>
  </form>
  <p class="text-center"><a href="/products/<?= $category ?>" class="text-reset">Remove all</a></p>
</div>
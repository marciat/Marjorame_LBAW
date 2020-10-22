  @if($user && $user->admin)
  <div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="banModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="banModalTitle">Are you sure you want to ban this user?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form>
          <fieldset>
            <div class="modal-body">
              <label class="sr-only" for="passwordCheckBan">Password</label>
              <input type="password" id="passwordCheckBan" class="form-control" placeholder="Password" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="cancel_button" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger" onclick="banUser(event)">Ban User</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  @endif
  <div class="product">
    <div class="product_gallery">
      <ul class="thumbnails">
            <?php $i = 0; ?>
         @foreach ($photos as $photo_url)
            <?php $i = $i + 1; ?>
            @if(!is_null($photo_url))
            <div>
              <li>
                <a href="#slide{{ $i }}"><img alt="product image" src="{{ Storage::url($photo_url) }}" /> </a>
              </li>
            </div>
            @endif
          @endforeach
        </ul>

        <ul class="product_images">
          <?php $i = 0; ?>
          @foreach ($photos as $photo_url)
            <?php $i = $i + 1; ?>
            @if(!is_null($photo_url))
            <div>
              <li id="slide{{ $i }}">
                <img alt="product image" src="{{ Storage::url($photo_url) }}" alt="" /></li>
              </li>
            </div>
            @endif
          @endforeach
        </ul>
    </div>

    <div class="product_information">
      <h1 class="product_title">{{$product->name}}</h1>
      <h3 class="product_price">$ {{$product->price}}</h3>
      @for($i = 1; $i <= $product->rating; $i++)
        <img alt="star" src="{{ Storage::url('public/images/star.png') }}">
      @endfor
      @for($j = $product->rating + 1; $j <= 5; $j++)
        <img alt="empty star"  src="{{ Storage::url('public/images/empty_star.png') }}">
      @endfor
      <a>{{$product->rating}} ({{count($reviews)}} reviews)</a>
      <div class="info_divider"> <span></span> </div>
      <a class="product_description">{{$product->description}}</a>
      <div class="product_options">
        <form class="product_option">
        {{ csrf_field() }}
          @if(count($product->size) > 0)
            <div class="product_size">
              <a>Size:</a><br>
              @foreach($product->size as $size)
                <input type="radio" id="{{$size->size}}_size" name="product_size" value="{{$size->size}}">
                <label for="{{$size->size}}_size">{{$size->size}}</label>
              @endforeach
            </div>
          @endif
          <br>
          @if(count($product->color) > 0)
            <div class="other_option">
              <a>Color:</a><br>
              @foreach($product->color as $color)
                <input type="radio" id="{{$color->color}}_color" name="product_color" value="{{$color->color}}">
                <label for="{{$color->color}}_color">{{$color->color}}</label>
              @endforeach
            </div>
          @endif
          <br>
          @if(!is_null($product->extra_characteristic))
            <div class="other_option">
              <a>{{$product->extra_characteristic->name}}:</a><br>
              <input type="radio" id="{{$product->extra_characteristic->option1}}" name="product_extra" value="{{$product->extra_characteristic->option1}}">
              <label for="{{$product->extra_characteristic->option1}}">{{$product->extra_characteristic->option1}}</label>
              <input type="radio" id="{{$product->extra_characteristic->option2}}" name="product_extra" value="{{$product->extra_characteristic->option2}}">
              <label for="{{$product->extra_characteristic->option2}}">{{$product->extra_characteristic->option2}}</label>
              @if(!is_null($product->extra_characteristic->option3))
                <input type="radio" id="{{$product->extra_characteristic->option3}}" name="product_extra" value="{{$product->extra_characteristic->option3}}">
                <label for="{{$product->extra_characteristic->option3}}">{{$product->extra_characteristic->option3}}</label>
              @endif
              @if(!is_null($product->extra_characteristic->option4))
                <input type="radio" id="{{$product->extra_characteristic->option4}}" name="product_extra" value="{{$product->extra_characteristic->option4}}">
                <label for="{{$product->extra_characteristic->option4}}">{{$product->extra_characteristic->option4}}</label>
              @endif
            </div>
          @endif
          <div class="quantity_input">
            <a>Quantity: </a>
            <div class="dec quant_button"><i class="fas fa-minus-circle" onclick="decrementQuantity()"></i></div>
            <label class="sr-only" for="quantity">Quantity</label>
            <input type="number" name="quantity" class="quantity" id="quantity" value="1" min="1" max="99" required>
            <div class="inc quant_button"><i class="fas fa-plus-circle" onclick="incrementQuantity()"></i></div>
          </div>
        </form>
        <div class="row">
          <div class="col-2 ml-1 mt-3">
           <form class="favorite_product" action="/product/<?=$product->id?>/favorite" method="post" >
            {{ csrf_field() }}
              <input id="favorite_product_btn" type="submit" class="favorite_btn invisible" />
              <label for="favorite_product_btn"><i class="fas fa-heart visible"></i></label>
            </form>
          </div>
          <div class="col-2 mt-5">
            <label class="sr-only" for="add_to_cart_btn">Add to Cart</label>
            <input id="add_to_cart_btn" class="submit_action_btn" type="submit" value="Add to Cart" onclick="addToCart(event,{{$product->id}})">
          </div>
        </div>
        <div>
          @if (session()->has('success_add_favorite'))
            <span class="success">
                {{ session()->get('success_add_favorite') }}
              </span>
          @endif
          @if (session()->has('error_add_favorite'))
            <span class="error">
              {{ session()->get('error_add_favorite') }}
            </span>
          @endif
        </div>
        <span class="error row px-3" id="cartError"></span>
        <span class="success row px-3" id="cartSuccess"></span>
      </div>
    </div>
    <div class="break"></div>
    <div class="product_reviews" id="reviews">
      <h2>Reviews</h2>
      <div class="info_divider"> <span></span> </div>
      <div class="row">
        <div class="col-md-6">
          <div class="reviews_graph">
            <div class="side">
              <div>5 <i class="fas fa-star"></i></div>
          </div>
          <div class="middle">
            <div class="bar-container">
              <div class="bar-5"></div>
            </div>
          </div>
          <div class="side right">
            <div>2</div>
          </div>
          <div class="side">
            <div>4 <i class="fas fa-star"></i></div>
          </div>
          <div class="middle">
            <div class="bar-container">
              <div class="bar-4"></div>
            </div>
          </div>
          <div class="side right">
            <div>1</div>
          </div>
          <div class="side">
            <div>3 <i class="fas fa-star"></i></div>
          </div>
          <div class="middle">
            <div class="bar-container">
              <div class="bar-3"></div>
            </div>
          </div>
          <div class="side right">
            <div>2</div>
          </div>
          <div class="side">
            <div>2 <i class="fas fa-star"></i></div>
          </div>
          <div class="middle">
            <div class="bar-container">
              <div class="bar-2"></div>
            </div>
          </div>
          <div class="side right">
            <div>0</div>
          </div>
          <div class="side">
            <div>1 <i class="fas fa-star"></i></div>
          </div>
          <div class="middle">
            <div class="bar-container">
              <div class="bar-1"></div>
            </div>
          </div>
          <div class="side right">
            <div>0</div>
          </div>
        </div>
      </div>
      @if($purchased)
      <div class="col-md-6 my-2">
      @else
      <div class="col-md-6 my-2 invisible">
      @endif
        <form class="submit_review">
        {{ csrf_field() }}
          <label class="sr-only" for="review_title">Review Title</label>
          <input type="text" id="review_title" name="review_title" placeholder="Review Title">
          <label class="sr-only" for="review_text"">Write your review here</label>
          <textarea id="review_text" maxlength="500" placeholder="Write your review here"></textarea>
          <span class="error row px-3" id="reviewError"></span>
          <div class="row">
            <div class="col-md-5">
              <fieldset class="star_rating" id="star_rating_field">
                <label class="sr-only" for="star5">5 Stars</label>
                <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 stars"><i class="fas fa-star" checked></i></label>
                <label class="sr-only" for="star4">4 Stars</label>
                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                <label class="sr-only" for="star3">3 Stars</label>
                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                <label class="sr-only" for="star2">2 Stars</label>
                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                <label class="sr-only" for="star1">1 Stars</label>
                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"><i class="fas fa-star"></i></label>
              </fieldset>
            </div>
            <div class="col-md-1">
              <label class="sr-only" for="submit_review_btn">Submit Review</label>
              <input id="submit_review_btn" class="submit_action_btn" type="submit" value="Submit Review">
            </div>
          </div>
        </form>
      </div>
        
    </div>
    <div class="all_reviews">
      @include('partials.reviews',['reviews' => $reviews, 'user' => $user])
    </div>
  </div>

</div>
<script> let productId = {{$product->id}} </script>
<script src="{{ asset('js/review.js') }}" defer> </script>
<script src="{{ asset('js/admin.js') }}" defer> </script>
<script src="{{ asset('js/add_to_cart.js') }}" defer> </script>
<script src="{{ asset('js/quantity.js') }}" defer></script>
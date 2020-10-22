<div class="cart_product row my-md-3 my-5 align-items-center" data_id = "{{$cart_prods->pivot->id}}">
    <div class="col-md-3 col-5">
        <a href="{{ url('product/'.$cart_prods->id) }}">
            <img src="{{ Storage::url($cart_prods->getPhoto($cart_prods->photo_id)) }}" alt="cart product">
        </a>
    </div>
    <div class="col-md-5 col-7">
        <h5 class="cart_product_name"><?=$cart_prods->name?></h5>
        <i class="far fa-trash-alt cart_delete_product"></i>
    </div>
    <div class="col-md-2 col-8">
        <div class="quantity_input">
            <label class="sr-only" for="quantity">Quantity</label>
            <div class="dec quant_button"><i class="fas fa-minus-circle"></i></div>
            <input type="number" name="quantity" class="quantity" id="quantity-{{$cart_prods->pivot->id}}" value="<?=$cart_prods->pivot->quantity?>" min="1" max="99" required>
            <div class="inc quant_button"><i class="fas fa-plus-circle"></i></div>
        </div>
    </div>
    <div class="col-md-2 col-4 pt-4">
        <p class="cart_prod_price">$ <?=$cart_prods->price?></p>
    </div>
</div>
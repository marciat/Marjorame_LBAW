<div class="container" id="cart_container">
    <div class="row">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pt-2 mx-3 mt-3">
            <h1 class="h2">Your Cart</h1>
        </div>
    </div>

    <hr class="pb-3">

    <div class="row my-md-3 my-5">
        <div class="col-md-4 col-5">
            <p class="cart_header">Item</p>
        </div>
        <div class="col-md-4 col-7">
        </div>
        <div class="col-md-2 col-6">
            <p class="cart_header">Quantity</p>
        </div>

        <div class="col-md-2 col-6">
            <p class="cart_header">Price</p>
        </div>
    </div>

    @each('partials.cart_product', $cart_prods, 'cart_prods', 'partials.cart_empty')

    <hr class="pt-3">

    <div class="row justify-content-around">
        <div class="col-md-3 col-6 ">
            <h4> Total </h4>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-2 col-6">
            <h4 id="cart_total">$ 0.00</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        @if (session()->has('empty'))
            <span class="error">
              {{ session()->get('empty') }}
            </span>
        @endif
    </div>

    <span class="error row px-3" id="cartError"></span>

    <div class="row justify-content-center">
        <form action="/checkout">
            <fieldset>
                {{ csrf_field() }}
                <?php if(count($cart_prods) == 0) { ?>
                    <button class="submit_action_btn" value="Proceed to Checkout">Proceed to Checkout</button>
                <?php } else { ?>
                    <button class="submit_action_btn" type="submit" value="Proceed to Checkout">Proceed to Checkout</button>
                <?php } ?>
            </fieldset>
        </form>
    </div>


</div>
<script src="{{ asset('js/quantity.js') }}" defer></script>
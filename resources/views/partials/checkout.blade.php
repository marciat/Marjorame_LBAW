<div class="container">
    <div class="row mt-5">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-pill"><?=count($products)?></span>
            </h4>
            <ul class="list-group mb-3">
                @each('partials.checkout_item', $products, 'product')
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total</span>
                    <strong>$ <?=$price?></strong>
                </li>
            </ul>

            
        </div>
        <div class="col-md-7 order-md-1">
            <form class="needs-validation" method="post" action="{{ route('checkout') }}">
                {{ csrf_field() }}
                <fieldset>
                    <legend><h3 class="my-3">Shipping Information:</h3></legend>
                    <div class="mb-3">
                        <label for="fLName">Name</label>
                        <input type="text" class="form-control" id="fLName" name="full_name" placeholder="" value="<?= $user->first_name ?> <?= $user->last_name ?>" required>
                        @if ($errors->has('full_name'))
                            <span class="error">
                            {{ $errors->first('full_name') }}
                            </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class=" col-md-8 mb-3">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="" value="<?= $address->street ?>" required>
                            @if ($errors->has('address'))
                                <span class="error">
                            {{ $errors->first('address') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="user_residence_number">Residence number</label>
                            <input type="text" class="form-control" id="residence_number " name="residence_number" placeholder="" value="<?= $address->residence_number ?>" required>
                            @if ($errors->has('residence_number'))
                                <span class="error">
                            {{ $errors->first('residence_number') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-md-8 mb-3">
                            <label for="address2">Address 2 (Optional)</label>
                            <input type="text" class="form-control" name="address2" id="additional_information" value="<?= $address->additional_information ?>" placeholder="">
                            @if ($errors->has('address2'))
                                <span class="error">
                            {{ $errors->first('address2') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="" value="<?= $city->name ?>" required>
                            @if ($errors->has('city'))
                                <span class="error">
                            {{ $errors->first('city') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="country">Country</label>
                            <select class="custom-select d-block w-100" id="country" name="country" required>
                                <option value="">Choose...</option>
                                <?php if (strcmp($country->name, 'Portugal') == 0) { ?>
                                    <option value='Portugal' selected>Portugal</option>
                                    <option value='Germany'>Germany</option>
                                    <option value='Netherlands'>Netherlands</option>
                                    <option value='France'>France</option>
                                    <option value='Spain'>Spain</option>
                                    <option value='Italy'>Italy</option>

                                <?php } else  if (strcmp($country->name, 'Italy') == 0) { ?>
                                    <option value='Portugal'>Portugal</option>
                                    <option value='Germany'>Germany</option>
                                    <option value='Netherlands'>Netherlands</option>
                                    <option value='France'>France</option>
                                    <option value='Spain'>Spain</option>
                                    <option value='Italy' selected>Italy</option>

                                <?php } else if (strcmp($country->name, 'Germany') == 0) { ?>
                                    <option value='Portugal'>Portugal</option>
                                    <option value='Germany' selected>Germany</option>
                                    <option value='Netherlands'>Netherlands</option>
                                    <option value='France'>France</option>
                                    <option value='Spain'>Spain</option>
                                    <option value='Italy'>Italy</option>

                                <?php } else if (strcmp($country->name, 'Netherlands') == 0) { ?>
                                    <option value='Portugal'>Portugal</option>
                                    <option value='Germany'>Germany</option>
                                    <option value='Netherlands' selected>Netherlands</option>
                                    <option value='France'>France</option>
                                    <option value='Spain'>Spain</option>
                                    <option value='Italy'>Italy</option>

                                <?php } else if (strcmp($country->name, 'Spain') == 0) { ?>
                                    <option value='Portugal'>Portugal</option>
                                    <option value='Germany'>Germany</option>
                                    <option value='Netherlands' selected>Netherlands</option>
                                    <option value='France'>France</option>
                                    <option value='Spain' selected>Spain</option>
                                    <option value='Italy'>Italy</option>

                                <?php } else if (strcmp($country->name, 'France') == 0) { ?>
                                    <option value='Portugal'>Portugal</option>
                                    <option value='Germany'>Germany</option>
                                    <option value='Netherlands' selected>Netherlands</option>
                                    <option value='France' selected>France</option>
                                    <option value='Spain'>Spain</option>
                                    <option value='Italy'>Italy</option>

                                <?php } else { ?>
                                    <option value='Portugal'>Portugal</option>
                                    <option value='Germany'>Germany</option>
                                    <option value='Netherlands' selected>Netherlands</option>
                                    <option value='France'>France</option>
                                    <option value='Spain'>Spain</option>
                                    <option value='Italy'>Italy</option>

                                <?php }  ?>
                            </select>
                            @if ($errors->has('country'))
                                <span class="error">
                                {{ $errors->first('country') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="zip">Zip Code</label>
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="" value="<?= $address->zip_code ?>" required>
                            @if ($errors->has('zip'))
                                <span class="error">
                                {{ $errors->first('zip') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="" value="<?= $buyer->phone_number ?>" required>
                            @if ($errors->has('phone_number'))
                                <span class="error">
                                {{ $errors->first('phone_number') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend><h3 class="my-3">Billing Information:</h3></legend>
                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" value="Credit" checked required>
                            <label class="custom-control-label" for="credit">Credit card</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" value="Debit" required>
                            <label class="custom-control-label" for="debit">Debit card</label>
                        </div>
                        @if ($errors->has('paymentMethod'))
                            <span class="error">
                            {{ $errors->first('paymentMethod') }}
                            </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-name">Name</label>
                            <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required>
                            <small class="text-muted">Full name as displayed on card</small>
                            @if ($errors->has('cc-name'))
                                <span class="error">
                                {{ $errors->first('cc-name') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cc-number">Card number</label>
                            <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" maxlength="20" required>
                            @if ($errors->has('cc-number'))
                                <span class="error">
                                {{ $errors->first('cc-number') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">Expiration Date</label>
                            <input type="text" class="form-control" name="cc-expiration" id="cc-expiration" placeholder="MM/YY" maxlength="5" required>
                            @if ($errors->has('cc-expiration'))
                                <span class="error">
                                {{ $errors->first('cc-expiration') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">CVV</label>
                            <input type="text" class="form-control" name="cc-cvv" id="cc-cvv" placeholder="XXX" maxlength="3" required>
                            @if ($errors->has('cc-cvv'))
                                <span class="error">
                                {{ $errors->first('cc-cvv') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cc-number">VAT</label>
                            <input type="text" class="form-control" name="vat-number" id="vat-number" value="<?= $buyer->vat ?>" placeholder="" maxlength="20" required>
                            @if ($errors->has('vat-number'))
                                <span class="error">
                                {{ $errors->first('vat-number') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </fieldset>

                <hr class="mb-4">
                <div class="row justify-content-center">
                    <button class="submit_action_btn px-5" type="submit" value="Checkout">Checkout</button>
                </div>
            </form>
        </div>
    </div>
</div>
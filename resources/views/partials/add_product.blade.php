<div class="container">
    <div class="row">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pt-2 mx-3 mt-3">
            <h1 class="h2">Add Product</h1>
        </div>
    </div>

    <hr class="pb-3">

    <form class="form-add_product" id="form-add_product" method="POST" action="{{ route('add_product') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <fieldset>
            <legend><h2>Product Information:</h2></legend>
            <div class="row my-md-3 my-5">
                <div class="col-md-6">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" value="{{ old('product_name') }}" required>
                    <label for="product_price">Price($)</label>
                    @if ($errors->has('product_name'))
                        <span class="error">
                        {{ $errors->first('product_name') }}
                        </span>
                    @endif
                    <input type="number" class="form-control" id="product_price" name="product_price" placeholder="10.00" value="{{ old('product_price') }}" required>
                    <label for="product_category">Category</label>
                    @if ($errors->has('product_price'))
                        <span class="error">
                        {{ $errors->first('product_price') }}
                        </span>
                    @endif
                    <select class="custom-select d-block w-100" id="product_category" name="product_category" required>
                        <option value="">Choose...</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Beauty">Beauty</option>
                        <option value="Decor">Decor</option>
                    </select>
                    @if ($errors->has('product_category'))
                        <span class="error">
                        {{ $errors->first('product_category') }}
                        </span>
                    @endif

                    <div id="product_subcategory_div">
                        <label for="product_subcategory">Subcategory</label>
                        <select class="custom-select d-block w-100" id="product_subcategory" name="product_subcategory" required>
                            <option value="">Choose...</option>
                        </select>
                    </div>
                    @if ($errors->has('product_subcategory'))
                        <span class="error">
                        {{ $errors->first('product_subcategory') }}
                        </span>
                    @endif

                    <div id="product_subcategory2_div">
                        <label for="product_subcategory2">Sub-subcategory</label>
                        <select class="custom-select d-block w-100" id="product_subcategory2" name="product_subcategory2">
                            <option value="">Choose...</option>
                        </select>
                    </div>
                    @if ($errors->has('product_subcategory2'))
                        <span class="error">
                        {{ $errors->first('product_subcategory2') }}
                        </span>
                    @endif

                </div>

                <div class="col-md-6 new_prod_description">
                    <label for="product_description_textbox">Description</label>
                    <textarea class="form-control" id="product_description_textbox"
                            name="product_description_textbox"
                            maxlength="500" value="{{ old('product_description_textbox') }}"
                            placeholder="Write the product's description here..."></textarea>
                    @if ($errors->has('product_description_textbox'))
                        <span class="error">
                        {{ $errors->first('product_description_textbox') }}
                        </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <fieldset>
                        <legend><h2>Size:</h2></legend>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_size[]" value="XXS" class="custom-control-input" id="sizeXXS">
                            <label class="custom-control-label" for="sizeXXS">XXS</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_size[]" value="XS" class="custom-control-input" id="sizeXS">
                            <label class="custom-control-label" for="sizeXS">XS</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_size[]" value="S" class="custom-control-input" id="sizeS">
                            <label class="custom-control-label" for="sizeS">S</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_size[]" value="M" class="custom-control-input" id="sizeM">
                            <label class="custom-control-label" for="sizeM">M</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_size[]" value="L" class="custom-control-input" id="sizeL">
                            <label class="custom-control-label" for="sizeL">L</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_size[]" value="XL" class="custom-control-input" id="sizeXL">
                            <label class="custom-control-label" for="sizeXL">XL</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_size[]" value="XXL" class="custom-control-input" id="sizeXXL">
                            <label class="custom-control-label" for="sizeXXL">XXL</label>
                        </div>  
                    </fieldset>
                </div>
                @if ($errors->has('product_size'))
                    <span class="error">
                  {{ $errors->first('product_size') }}
                </span>
                @endif
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <fieldset>
                        <legend><h2>Color:</h2></legend>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_color[]" value="Black" class="custom-control-input" id="color_black">
                            <label class="custom-control-label" for="color_black">Black</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_color[]" value="White" class="custom-control-input" id="color_white">
                            <label class="custom-control-label" for="color_white">White</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_color[]" value="Brown" class="custom-control-input" id="color_brown">
                            <label class="custom-control-label" for="color_brown">Brown</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_color[]" value="Blue" class="custom-control-input" id="color_blue">
                            <label class="custom-control-label" for="color_blue">Blue</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_color[]" value="Red" class="custom-control-input" id="color_red">
                            <label class="custom-control-label" for="color_red">Red</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_color[]" value="Green" class="custom-control-input" id="color_green">
                            <label class="custom-control-label" for="color_green">Green</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="other" class="custom-control-input" id="color_other">
                            <label class="custom-control-label" for="color_other">Other</label>
                        </div>
                    </fieldset>
                </div>
                @if ($errors->has('product_color'))
                    <span class="error">
                  {{ $errors->first('product_color') }}
                </span>
                @endif
                @if ($errors->has('product_color_other'))
                    <span class="error">
                  {{ $errors->first('product_color_other') }}
                </span>
                @endif
            </div>

            <div class="form-group custom_option mx-3">
                <fieldset>
                    <legend><h2>Custom Option (optional):</h2></legend>
                    <label for="option_title">Option Title</label>
                    <input type="text" name="option_title" value="" class="form-control" id="option_title">
                    @if ($errors->has('option_title'))
                        <span class="error">
                        {{ $errors->first('option_title') }}
                        </span>
                    @endif
                    <div class="row my-2">
                        <div class="col-md-6">
                            <label for="option_1">Option 1</label>
                            <input type="text" name="option_1" value="" class="form-control" id="option_1">
                            @if ($errors->has('option_1'))
                                <span class="error">
                                {{ $errors->first('option_1') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="option_2">Option 2</label>
                            <input type="text" name="option_2" value="" class="form-control" id="option_2">
                            @if ($errors->has('option_2'))
                                <span class="error">
                                {{ $errors->first('option_2') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-md-6">
                            <label for="option_3">Option 3</label>
                            <input type="text" name="option_3" value="" class="form-control" id="option_3">
                            @if ($errors->has('option_3'))
                                <span class="error">
                                {{ $errors->first('option_3') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="option_4">Option 4</label>
                            <input type="text" name="option_4" value="" class="form-control" id="option_4">
                            @if ($errors->has('option_4'))
                                <span class="error">
                                {{ $errors->first('option_4') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <fieldset>
            <legend><h2>Product Photos:</h2></legend>
            <div class="file_zone">
                <label for="files">Images</label>
                <input type="file" accept="image/jpeg, image/jpg, image/png, image/gif" id="files" name="files[]" multiple required/>

                @if ($errors->has('files'))
                    <span class="error">
                {{ $errors->first('files') }}
                </span>
                @endif
            </div>
            <span class="help-block">Choose 1 to 5 images</span>
        </fieldset>

        <button id="add_to_cart_btn" class="submit_action_btn my-5" type="submit">Add Product</button>


    </form>

</div>
'use strict'

let color_other = $("#color_other");

color_other.change(function () {
    let tag = $("#color_other-text");

    if(tag.length === 0){
        color_other.parent().append('<input type="text" name="product_color_other" value="" placeholder="Color" class="form-control" id="color_other-text">');
    }else{
        tag.remove()
    }

});

let category = $('#product_category');
let subcategory = $('#product_subcategory');
let subsubcategory = $('#product_subcategory2');
let subcategory_div = $('#product_subcategory_div');
let subsubcategory_div = $('#product_subcategory2_div');

category.on('change', function(){

    subcategory.html('');
    if(category.val()==='Fashion'){
        subcategory.append('<option selected="selected" value="Bags and Wallets">Bags and Wallets</option>');
        subcategory.append('<option value="Belts">Belts</option>');
        subcategory.append('<option value="Clothing">Clothing</option>');
        subcategory.append('<option value="Jewelry">Jewelry</option>');
        subcategory.append('<option value="Socks">Socks</option>');
        subcategory.append('<option value="Watches">Watches</option>');
        subcategory.append('<option value="Winter Accessories">Winter Accessories</option>');
        subcategory_div.show();
    }else if(category.val() === 'Beauty'){
        subcategory.append('<option selected="selected" value="Fragrances">Fragrances</option>');
        subcategory.append('<option value="Hygiene">Hygiene</option>');
        subcategory.append('<option value="Makeup">Makeup</option>');
        subcategory_div.show();
    } else if(category.val() === 'Decor'){
        subcategory.append('<option selected="selected" value="Bathroom">Bathroom</option>');
        subcategory.append('<option value="Bedroom">Bedroom</option>');
        subcategory.append('<option value="Kitchen">Kitchen</option>');
        subcategory.append('<option value="Living Room">Living Room</option>');
        subcategory.append('<option value="Outdoors">Outdoors</option>');
        subcategory_div.show();
    }else{
        subcategory.val("");
        subcategory_div.hide();
        subsubcategory.val("");
        subsubcategory_div.hide();
    }
    subcategory.trigger('change');
});

subcategory.on('change', function(){

    subsubcategory.html('');
    if(subcategory.val()==='Clothing'){
        subsubcategory.append('<option selected="selected" value="Tops">Tops</option>');
        subsubcategory.append('<option value="Bottoms">Bottoms</option>');
        subsubcategory_div.show();
    }else if(subcategory.val() === 'Bags and Wallets'){
        subsubcategory.append('<option selected="selected" value="Wallets">Wallets</option>');
        subsubcategory.append('<option value="Backpacks">Backpacks</option>');
        subsubcategory.append('<option value="Tote Bags">Tote Bags</option>');
        subsubcategory.append('<option value="Shoulder Bags">Shoulder Bags</option>');
        subsubcategory_div.show();
    }else if(subcategory.val() === 'Jewelry'){
        subsubcategory.append('<option selected="selected" value="Bracelets">Bracelets</option>');
        subsubcategory.append('<option value="Earrings">Earrings</option>');
        subsubcategory.append('<option value="Necklaces">Necklaces</option>');
        subsubcategory.append('<option value="Rings">Rings</option>');
        subsubcategory_div.show();
    }else if(subcategory.val() === 'Winter Accessories'){
        subsubcategory.append('<option selected="selected" value="Beanies">Beanies</option>');
        subsubcategory.append('<option value="Gloves">Gloves</option>');
        subsubcategory.append('<option value="Scarves">Scarves</option>');
        subsubcategory_div.show();
    }else if(subcategory.val() === 'Makeup'){
        subsubcategory.append('<option selected="selected" value="Accessories">Accessories</option>');
        subsubcategory.append('<option value="Eyes">Eyes</option>');
        subsubcategory.append('<option value="Face">Face</option>');
        subsubcategory.append('<option value="Lips">Lips</option>');
        subsubcategory_div.show();
    }else{
        subsubcategory.val("");
        subsubcategory_div.hide();
    }

    subsubcategory.trigger('change');
});





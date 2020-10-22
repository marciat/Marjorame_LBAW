let echoCart = function(){
    if(this.status == 200){
        let content = document.querySelector("#content");

        content.innerHTML = this.responseText;

        setListeners();
        getTotalCartPrice();
    }
    else{
        let cartError = document.querySelector("#cartError");
        cartError.innerHTML = "Error: unable to refresh cart items list";
    }
}

let cartQuantUpdateHandler = function(){
    if(this.status == 200){
        sendAjaxRequest('get', '/cart/items', {}, echoCart);
    }
    else{
        let cartError = document.querySelector("#cartError");
        cartError.innerHTML = "Error: " + this.responseText;
    }
}

function incrementQuantity(id){
    let valueElement;
    if(id == undefined){
        valueElement = document.querySelector("#quantity");
    }
    else{
        valueElement = document.querySelector("#quantity-"+id);
    }
    
    let oldValue = valueElement.value;
    
    let newValue;
    if(oldValue < 99) 
        newValue = parseFloat(oldValue) + 1;
    else newValue = 99;

    valueElement.value = newValue;

    if(valueElement.onchange != undefined){
        valueElement.onchange();
    }
}

function decrementQuantity(id){
    let valueElement;
    if(id == undefined){
        valueElement = document.querySelector("#quantity");
    }
    else{
        valueElement = document.querySelector("#quantity-"+id);
    }
    
    let oldValue = valueElement.value;
    
    let newValue;
    if(oldValue > 1) 
        newValue = parseFloat(oldValue) - 1;
    else newValue = 1;

    valueElement.value = newValue;

    if(valueElement.onchange != undefined){
        valueElement.onchange();
    }
}

function updateQuantity(id){
    let valueElement = document.querySelector("#quantity-"+id);
    let newValue = parseFloat(valueElement.value);

    sendAjaxRequest('put', '/cart/' + id, {quantity : newValue}, cartQuantUpdateHandler);
}

function setListeners(){
    let products = document.querySelectorAll(".cart_product");
    if(products == undefined){
        return;
    }

    for(let i = 0; i < products.length; ++i){
        let id = parseInt(products[i].getAttribute("data_id"));

        let decrementer = products[i].querySelector(".dec");
        let incrementer = products[i].querySelector(".inc");

        decrementer.onclick = () => {decrementQuantity(id)};
        incrementer.onclick = () => {incrementQuantity(id)};

        let quantityElement = products[i].querySelector("#quantity-"+id);
        quantityElement.onchange = () => {updateQuantity(id)};
    }

    $(".cart_delete_product").on("click", function(event) {
        event.preventDefault();

        let $button = $(this);

        let cartprod_id = $button.parent().parent().attr("data_id");

        sendAjaxRequest('delete', '/cart/' + cartprod_id, {}, cartQuantUpdateHandler);
    });
}

function getTotalCartPrice(){
    let total_price_element = document.getElementById("cart_total");
    if(total_price_element == undefined){
        return;
    }

    let cart_product = document.getElementsByClassName("cart_product");

    let total_price = 0.0;

    for (let i = 0; i < cart_product.length; i++) {
        const quant = cart_product[i].querySelector(".quantity").value;
        const price = cart_product[i].querySelector(".cart_prod_price").textContent.replace("$ ", "");
        total_price += (parseFloat(quant) * parseFloat(price));
    } 

    total_price_element.innerHTML = "$ " + total_price.toFixed(2);
    
}

getTotalCartPrice();
setListeners();
function addToCart(event, prod_id){
    let quantityElement = document.querySelector("#quantity");

    sendAjaxRequest('post', '/cart/add/' + prod_id, {quantity: quantityElement.value}, cartResponse);
}

function cartResponse(){
    let errorElement = document.querySelector("#cartError");
    let successElement = document.querySelector("#cartSuccess");
    if(this.status == 201){
        successElement.innerHTML = "Added to the cart";
        errorElement.innerHTML = "";
    }
    else{
        errorElement.innerHTML = "Could not add the product to the cart";
        successElement.innerHTML = "";
    }
}
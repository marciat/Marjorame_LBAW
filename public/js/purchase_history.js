'use strict'

function getPurchaseTotal(){
    let purchases = document.getElementsByClassName("purchase_in_history");

    for (let i = 0; i < purchases.length; i++) {
        let products = purchases[i].querySelectorAll(".product_purchase_history");

        let total_price = 0.0;
        
        for(let j = 0; j < products.length; j++){

            const quant = products[j].querySelector(".quantity").textContent;
            const price = products[j].querySelector(".product_history_price").textContent;
            total_price += (parseFloat(quant) * parseFloat(price));
        }

        purchases[i].querySelector(".total_purchase_history").innerHTML = "$ " + total_price;
    } 
}

getPurchaseTotal();





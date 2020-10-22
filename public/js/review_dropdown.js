function setReviewButtonHandlers(){
    let buttons = document.getElementsByClassName("review_options_btn");
    for(let i = 0; i < buttons.length; ++i){
        buttons[i].onclick = function(event){
            this.nextElementSibling.style = "display: block";
        }.bind(buttons[i]);
    }
}

setReviewButtonHandlers();

window.onclick = function(event) {
    if (!event.target.matches('.review_options_btn')) {
        let menus = document.getElementsByClassName("review_dropdown_content");
        for (let i = 0; i < menus.length; i++) {
            menus.item(i).style.display = "none";
        }   
    }
}
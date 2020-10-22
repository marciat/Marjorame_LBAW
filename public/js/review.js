let submitReview = document.querySelector('#submit_review_btn');

let echoReviews = function(){
    if(this.status == 200){
        let reviewsElement = document.querySelector(".all_reviews");
        let reviewListButton = document.querySelector("#show_more_btn");
        reviewsElement.innerHTML = this.responseText;
        reviewsElement.appendChild(reviewListButton);

        setReviewButtonHandlers();
    }
    else{
        let reviewError = document.querySelector("#reviewError");
        reviewError.innerHTML = "Error: unable to update reviews";
    }
}

let reviewUpdateHandler = function(){
    if(this.status == 200 || this.status == 201){
        sendAjaxRequest('get', productId + '/review/', {}, echoReviews);
    }
    else{
        let reviewError = document.querySelector("#reviewError");
        reviewError.innerHTML = "Error: " + this.statusText;
    }
}

let submitTask = function(event){
    event.preventDefault();

    sendAjaxRequest('put', productId + '/review/', getReviewObject(), reviewUpdateHandler);
} 

function getReviewObject(){
    let reviewTitle = document.querySelector("#review_title");
    let reviewDescription = document.querySelector("#review_text");
    let reviewRating = document.querySelector('#star_rating_field > input[name = "rating"]:checked');

    if(reviewTitle.value == "" || reviewTitle.value == undefined){
        alert("Title missing (this message is only provisional)");
        return;
    } 
    if(reviewDescription.value == "" || reviewDescription.value == undefined) {
        alert("Description missing (this message is only provisional)");
        return;
    } 
    if(reviewRating.value == undefined){
        alert("Rating missing (this message is only provisional)");
        return;
    } 
    return {title : reviewTitle.value, description : reviewDescription.value, rating : reviewRating.value};
}

if(submitReview != undefined && submitReview != null){
    submitReview.onclick = submitTask;
}

function editReview(event,id){
    event.preventDefault();
    let prevReviewTitle = document.querySelector("#review-title-" + id);
    let prevReviewText = document.querySelector("#review-text-" + id);

    let reviewTitle = document.querySelector("#review_title");
    let reviewText = document.querySelector("#review_text");
    let reviewRating = document.querySelector("#review_stars_" + id);

    let reviewStar = document.querySelector("#star"+reviewRating.childElementCount);
    reviewStar.setAttribute("checked","checked");
    reviewTitle.value = prevReviewTitle.innerHTML;
    reviewText.value = prevReviewText.innerHTML;

    let reviewsHeader = document.querySelector("#reviews");
    reviewsHeader.scrollIntoView();

    submitReview.onclick = (e) => {editReviewSubmit(e,id);};

    submitReview.onclick = submitTask;
}

function editReviewSubmit(event,id){
    event.preventDefault();

    sendAjaxRequest('post', '/review/' + id, getReviewObject(), reviewUpdateHandler);
} 
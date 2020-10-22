@foreach ($reviews as $review)
<div class="row my-3">
    <div class="col-md-2 my-2">
        <div class="review_stars" id="review_stars_{{$review->id}}">
            @for($i = 1; $i <= $review->rating; $i++)
                <img alt="star" src="{{ Storage::url('public/images/star.png') }}">
            @endfor
            @for($j = $review->rating + 1; $j <= 5; $j++)
                <img alt="empty star" src="{{ Storage::url('public/images/empty_star.png') }}">
            @endfor
        </div>
        <a class="review_username">{{$review->username}}</a>
        <div class="row ml-0">
            <a class="review_date">{{$review->date}}</a>
        </div>
    </div>
    <div class="col-md-9 mt-md-3 ml-md-n4" id="review-content-{{$review->id}}">
        <h5 class="review_title" id="review-title-{{$review->id}}">{{$review->title}}</h5>
        <p class="review_text" id="review-text-{{$review->id}}">{{$review->description}}</p>
    </div>
    @if($user && ($user->admin || ($user->buyer && $review->buyer == $user->buyer->id)))
    <div class="col-md-1 col-2 order-md-12 mt-md-2 mt-3 my-2" id="review-options-{{$review->id}}">
        <div class="user_review_options">
            <button id="review_options_btn" class="review_options_btn"><i class="fas fa-ellipsis-v"></i></button>
            <div id="user_review_dropdown" class="review_dropdown_content">
                <a href="#" onclick="editReview(event,{{$review->id}})">Edit</a>
                <a href="#" onclick="deleteReview(event,{{$review->id}})">Delete</a>
                @if($user->admin)
                <a href="#" onclick="setUserForModeration(event,{{$review->buyer}})" data-toggle="modal" data-target="#banModal">Ban user</a>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endforeach
    
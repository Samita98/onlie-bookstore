@extends('front.common.main')
@section('contents')
<section class="product-detail-page">
    <div class="container">

      <div class="product-details">
        <div class="">
        @if (session('error_message'))
            <div class="alert alert-danger">
                {{ session('error_message') }}
            </div>
        @endif
        @if(Session::has('success_message'))
        <p class="alert alert-success">{{ Session::get('success_message') }}</p>
        @endif
        <div class="row">
          <div class="col-lg-5">
            <div class="product-main-image">
              @if($product->media )
                <div id="gallery" class="product-section-content">
                  <a href="{{$product->media->get_attachment_url()}}">
                      {!!$product->media->get_attachment('thumb_600x600')!!}
                  </a>
                </div>
              @endif
            </div>
          </div>
          <div class="col-lg-7">  
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('category.detail', $product->category->permalink)}}">{{$product->category->title}}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
        </ol>
    </nav>        
            <div class="product-name-author">
            <div class="product-name">
            <h1>{{$product->title}}</h1>
            </div>
            @if($product->product_type)
            <div class="product-type downspace-between-detail">
              <span>{{$product->product_type}}</span>
            </div>
            @endif
            @if($product->author)
            <div class="product-author">
              <h6><span>Author: </span><a href="{{route('author.detail', $product->author->permalink)}}">{{$product->author->title}}</a></h6>
            </div>
            @endif
            </div>
            @if($product->price)
            <div class="product-price-box downspace-between-detail">
                <span class="product-price">NPR {{$product->price}}</span>
            </div>
            @endif
            @if($product->user)
            <div class="product-conatct-number downspace-between-detail">
              <h6><span>Contact: </span>{{$product->user->phone_no}}</h6>
            </div>
            @endif
            @if($product->user)
            <div class="product-whatsapp-number downspace-between-detail">
              <h6><span>Whatapps: </span>{{$product->user->whatsapp_no}}</h6>
            </div>
            @endif
            <div class="product-add-cart downspace-between-detail">
              <form method="POST" action="{{route('cart.add', $product->id)}}" class="product-add-to-wishlist">
              @csrf
              <input type="hidden" id="product_{{$product->id}}" name="product_quantity" class="form-control input-number" value="1">
              <button type="submit" class="detail-btn-add-cart"><i class="fa fa-shopping-cart"></i>
              <span>Add to Cart</span></button>
            </form>
            </div>
            @if($product->category)
            <div class="product-category downspace-between-detail">
              <span>Genre: </span><a href="{{route('category.detail', $product->category->permalink)}}">{{$product->category->title}}</a>
            </div>
            @endif
          </div>
          </div>
          
          <div class="product-detail-section">
          <div class="product-detail-tab">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="detail-tab" data-bs-toggle="tab" href="#productdetail" role="tab" aria-controls="productdetail" aria-selected="true">About the Book</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="ratingreview-tab" data-bs-toggle="tab" href="#ratingreview" role="tab" aria-controls="ratingreview" aria-selected="true">Ratings & Reviews</a>
              </li>
            </ul>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="productdetail" role="tabpanel" aria-labelledby="detail-tab">
                @if($product->detail)
                {!!$product->detail!!}
                @endif
              </div>
              <div class="tab-pane fade show" id="ratingreview" role="tabpanel" aria-labelledby="ratingreview-tab">
              <div class="">

              <div class="product-details-wrap-bottom">
              <div class="pro-details-review-wrap">
                  <div class="entry-product-section-heading">
                      <h2> Reviews</h2>
                  </div>
                  <div class="pro-details-review">
                  @if($reviews->count())
                  @php($reviewcount=0)
                  @foreach($reviews as $review)
                  @php($reviewcount++)
                  <div class="single-pro-details-review">
                    <div class="review-content">
                        <div class="review-name-rating">
                            <div class="review-rating">
                              <ul class="list-unstyled review-star-rating d-flex mb-0">
                              @for($i=1; $i<=5; $i++)
                              @if($i<=$review->rating)
                                <li><i class="fas fa-star"></i></li>
                                @else
                                    <li><i class="far fa-star"></i></li>
                                @endif
                                @endfor
                              </ul>
                            </div>
                            <div class="review-name">
                                <h6>{{$review->user->name}}</h6>
                            </div>
                        </div>
                        <p>{!!$review->review!!}</p>
                        <div class="review-date-btn">
                            <div class="review-date">
                                <span> {{$review->updated_at->diffForHumans()}} </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                  </div>
                  @endforeach  
                  @endif


                  <div class="ratting-form-wrapper">
                      <h3>Add a review</h3>
                      @if (Auth::check())

                          <form class="row g-3" method="POST" action="{{ route('user.review.add', $product->id) }}"
                                onsubmit="return submit_ajax_form(this);">
                              {{ csrf_field() }}

                              <div class="review-rating-text form-group col-lg-12">
                                  <label class="rating-lable-text control-label" style="float: left;">Rating:</label>
                                            <ul class="rating list-unstyled sub-rating pull-left">
                                              <li class="stars star-cb-group">
                                                <input name="rating" value="" type="hidden">
                                                <input @if(old('rating')=='5') checked=""  @endif id="rating-1" class="" title="" name="rating" value="5" required="required" type="radio">
                                                <label for="rating-1">5</label>
                                                <input @if(old('rating')=='4') checked=""  @endif id="rating-2" class="" title="" name="rating" value="4" required="required" type="radio">
                                                <label for="rating-2">4</label>
                                                <input  @if(old('rating')=='3') checked=""  @endif id="rating-3" class="" title="" name="rating" value="3" required="required" type="radio">
                                                <label for="rating-3">3</label>
                                                <input @if(old('rating')=='2') checked=""  @endif id="rating-4" class="" title="" name="rating" value="2" required="required" type="radio">
                                                <label for="rating-4">2</label>
                                                <input @if(old('rating')=='1') checked=""  @endif id="rating-5" class="" title="" name="rating" value="1" required="required" type="radio">
                                                <label for="rating-5">1</label>
                                              </li>
                                            </ul>
                              </div>
                              <div class="col-lg-12">
                                  <textarea class="form-control" rows="4" name="review" placeholder="Your Review here">{{ old('review') }}</textarea>
                              </div>
                              <div class="form-submit col-lg-12">
                                  <button type="submit" class="btn btn-primary">Post Review</button>
                              </div>
                          </form>
                      @else
                          <p>Please <a href="{{ route('login') }}">login</a> to write a review.</p>
                      @endif
                  </div>

                  </div>
                </div>
              </div>
              </div>
              </div>
            </div>

          </div>
          </div>
          
        </div>
      </div>

    @if($relatedproducts->count())
    <div class="related-product-section">
      <div class="section-title">
          <h2>YOU MAY ALSO LIKE</h2>
      </div>
      <div class="row small-gutters">
        @foreach($relatedproducts as $relatedproduct)
        <div class="col-6 col-md-4 col-xl-3">
          <div class="grid_item">
            <figure>
              <a href="{{route('product.detail', $relatedproduct->permalink)}}">
                @if($relatedproduct->media)
                  {!!$relatedproduct->media->get_attachment('thumb_175')!!}
                @endif
              </a>
              <div class="cart-add-btn cart-add-btn-replace">
                <form method="POST" action="{{route('cart.add', $relatedproduct->id)}}" class="product-add-to-wishlist">
                  @csrf
                  <input type="hidden" id="product_{{$relatedproduct->id}}" name="product_quantity" class="form-control input-number text-center" value="1">
                  <button type="submit" class="add_to_cart_button"><span>Add to cart</span></button>
                </form>
              </div>
            </figure>
            <a href="{{route('product.detail', $relatedproduct->permalink)}}">
              <h3>{{$relatedproduct->title}}</h3>
            </a>
            @if($relatedproduct->price)
            <div class="price_box">
              <span class="new_price">NPR {{$relatedproduct->price}}</span>
            </div>
            @endif
            @if($relatedproduct->product_type)
            <div class="product_type_box">
              <span class="product_type">{{$relatedproduct->product_type}}</span>
            </div>
            @endif
            <ul>
              <li>
                <a href="{{route('product.detail', $relatedproduct->permalink)}}" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Quick View">
                  <i class="fa-solid fa-eye"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    </div>

@endsection
@extends('front.common.main')
@section('contents')
<section class="search-section">
	<div class="container">
		<div>
			<h2>Search Books</h2>
		</div>

		<div class="row">
			@if($fproducts->count())
			@foreach($fproducts as $fproduct)
        <div class="col-6 col-md-4 col-xl-3">
          <div class="grid_item">
            <figure>
              <a href="{{route('product.detail', $fproduct->permalink)}}">
                @if($fproduct->media)
                  {!!$fproduct->media->get_attachment('thumb_175')!!}
                @endif
              </a>
              <div class="cart-add-btn cart-add-btn-replace">
                <form method="POST" action="{{route('cart.add', $fproduct->id)}}" class="product-add-to-wishlist">
                  @csrf
                  <input type="hidden" id="product_{{$fproduct->id}}" name="product_quantity" class="form-control input-number text-center" value="1">
                  <button type="submit" class="add_to_cart_button"><span>Add to cart</span></button>
                </form>
              </div>
            </figure>
            <a href="{{route('product.detail', $fproduct->permalink)}}">
              <h3>{{$fproduct->title}}</h3>
            </a>
            @if($fproduct->price)
            <div class="price_box">
              <span class="new_price">NPR {{$fproduct->price}}</span>
            </div>
            @endif
            @if($fproduct->product_type)
            <div class="product_type_box">
              <span class="product_type">{{$fproduct->product_type}}</span>
            </div>
            @endif
            <ul>
              <li>
                <a href="{{route('product.detail', $fproduct->permalink)}}" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Quick View">
                  <i class="fa-solid fa-eye"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
			@endforeach
			@else
			<h3>Sorry, Book Not found. Please try again.</h3>
			@endif
		</div>
	</div>
</section>
@endsection
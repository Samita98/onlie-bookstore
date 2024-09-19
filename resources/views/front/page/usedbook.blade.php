@extends('front/common/main')
@section('contents')
<section class="page-title">
    <div class="container">
      <div class="innerpage-section-title">
        <h1>{{$page->title}}</h1>
      </div>
    </div>
</section>
<section class="usedbook-page" id="PageDetail">
  <div class="container">
      <div class="">
        <div class="page-info">
          {!!$page->detail!!}
        </div>
      </div>
        @if($usedbooks->count()) 
        <div class="row category-list-product column-item-space">
            @php($di=0)
            @foreach($usedbooks as $usedbook)
            @php($di++) 
            <div class="col-6 col-md-4 col-xl-3">
              <div class="grid_item">
                <figure>
                  <a href="{{route('product.detail', $usedbook->permalink)}}">
                    @if($usedbook->media)
                      {!!$usedbook->media->get_attachment('thumb_175')!!}
                    @endif
                  </a>
                  <div class="cart-add-btn cart-add-btn-replace">
                    <form method="POST" action="{{route('cart.add', $usedbook->id)}}" class="product-add-to-wishlist">
                      @csrf
                      <input type="hidden" id="product_{{$usedbook->id}}" name="product_quantity" class="form-control input-number text-center" value="1">
                      <button type="submit" class="add_to_cart_button"><span>Add to cart</span></button>
                    </form>
                  </div>
                </figure>
                <a href="{{route('product.detail', $usedbook->permalink)}}">
                  <h3>{{$usedbook->title}}</h3>
                </a>
                @if($usedbook->price)
                <div class="price_box">
                  <span class="new_price">NPR {{$usedbook->price}}</span>
                </div>
                @endif
                @if($usedbook->product_type)
                <div class="product_type_box">
                  <span class="product_type">{{$usedbook->product_type}}</span>
                </div>
                @endif
                <ul>
                  <li>
                    <a href="{{route('product.detail', $usedbook->permalink)}}" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Quick View">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            @endforeach  
        </div><!-- end row -->
        @endif
  </div>
</section>

@endsection
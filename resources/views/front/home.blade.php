@extends('front.common.main')
@section('contents')
<main>

    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-inner">
        @php($i=0)
        @foreach($sliders as $slider)
        @php($i++)
        <div class="carousel-item @if($i==1) active @endif">
          @if($slider->media)
            {!!$slider->media->get_attachment()!!}
          @endif
        <div class="carousel-caption d-none d-md-block">
          <h5>{{$slider->title}}</h5>
          <p>{{$slider->caption}}</p>
        </div>
        </div>
        @endforeach
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    @if($recommendedProducts)
    <div class="container product-section-list">
      <div class="main_title">
        <h2>Recommended Books</h2>
        <span>Products</span>
      </div>
      <div class="row small-gutters">
      @foreach($recommendedProducts as $product_id => $score)
      <?php $product = \App\Model\Product::find($product_id); ?>
        <div class="col-6 col-md-4 col-xl-3">
          <div class="grid_item">
            <figure>
              <a href="{{route('product.detail', $product->permalink)}}">
                @if($product->media)
                  {!!$product->media->get_attachment('thumb_175')!!}
                @endif
              </a>
              <div class="cart-add-btn cart-add-btn-replace">
                <form method="POST" action="{{route('cart.add', $product->id)}}" class="product-add-to-wishlist">
                  @csrf
                  <input type="hidden" id="product_{{$product->id}}" name="product_quantity" class="form-control input-number text-center" value="1">
                  <button type="submit" class="add_to_cart_button"><span>Add to cart</span></button>
                </form>
              </div>
            </figure>
            <a href="{{route('product.detail', $product->permalink)}}">
              <h3>{{$product->title}}</h3>
            </a>
            @if($product->price)
            <div class="price_box">
              <span class="new_price">NPR {{$product->price}}</span>
            </div>
            @endif
            @if($product->product_type)
            <div class="product_type_box">
              <span class="product_type">{{$product->product_type}}</span>
            </div>
            @endif
            <ul>
              <li>
                <a href="{{route('product.detail', $product->permalink)}}" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Quick View">
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


    @if($latestproducts->count())
    <div class="container product-section-list">
      <div class="main_title">
        <h2>New Release</h2>
        <span>Products</span>
      </div>
      <div class="row small-gutters">
        @foreach($latestproducts as $fproduct)
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
      </div>
    </div>
    @endif

    <section class="home-parallax" @if(config('setting.firstparallax')) style="background-image: url('{!!get_attachment_url(config('setting.firstparallax'))!!}');" @endif>
      <div class="container">

      </div>
    </section>


    @if($fproducts->count())
    <div class="container product-section-list">
      <div class="main_title">
        <h2>Featured</h2>
        <span>Products</span>
      </div>
      <div class="row small-gutters">
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
      </div>
    </div>
    @endif

</main>
@endsection
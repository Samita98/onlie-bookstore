@extends('front/common/main')
@section('contents')

<section class="section-wrap pt-60 pb-30 catalog">
      <div class="container">
        <div class="row">
          <div class="category-list-section col-lg-9 order-lg-2">
            <div class="category-title-div">
                <h1>{{$category->title}}</h1>
            </div> 

            @if($category->products->count()) 
            <div class="row category-list-product column-item-space">
            @php($di=0)
            @foreach($category->products as $categories)
            @php($di++) 
            <div class="col-6 col-md-4 col-xl-3">
              <div class="grid_item">
                <figure>
                  <a href="{{route('product.detail', $categories->permalink)}}">
                    @if($categories->media)
                      {!!$categories->media->get_attachment('thumb_175')!!}
                    @endif
                  </a>
                  <div class="cart-add-btn cart-add-btn-replace">
                    <form method="POST" action="{{route('cart.add', $categories->id)}}" class="product-add-to-wishlist">
                      @csrf
                      <input type="hidden" id="product_{{$categories->id}}" name="product_quantity" class="form-control input-number text-center" value="1">
                      <button type="submit" class="add_to_cart_button"><span>Add to cart</span></button>
                    </form>
                  </div>
                </figure>
                <a href="{{route('product.detail', $categories->permalink)}}">
                  <h3>{{$categories->title}}</h3>
                </a>
                @if($categories->price)
                <div class="price_box">
                  <span class="new_price">NPR {{$categories->price}}</span>
                </div>
                @endif
                @if($categories->product_type)
                <div class="product_type_box">
                  <span class="product_type">{{$categories->product_type}}</span>
                </div>
                @endif
                <ul>
                  <li>
                    <a href="{{route('product.detail', $categories->permalink)}}" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Quick View">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            @endforeach  
            </div><!-- end row -->
            @endif
          </div> <!-- end col -->

          <!-- Sidebar -->
          <aside class="col-lg-3 sidebar">
            @if($categorylists->count()) 
            <div class="left-sidebar filter_categories sidebar-bottom-line">
              <h4 class="sidebar-title">Categories</h4>
              <ul>
              @foreach($categorylists as $categorylist)
                <li>
                  <a href="{{route('category.detail', $categorylist->permalink)}}"><span class="catTitle">{{$categorylist->title}}</span><span class="catCounter"> </span></a>
                </li>
                @endforeach
              </ul>
            </div>
            @endif
          </aside> <!-- end sidebar -->
    </div> <!-- end row -->
  </div> <!-- end container -->
</section>
@endsection
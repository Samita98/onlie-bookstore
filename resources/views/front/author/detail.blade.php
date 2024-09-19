@extends('front/common/main')
@section('contents')

<section class="section-wrap pt-60 pb-30 catalog">
      <div class="container">


        <div class="row">
          <div class="category-list-section col-lg-9 order-lg-2">
        <!-- Breadcrumbs -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{url('/author')}}">Author</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{$author->title}}</li>
        </ol>
      </nav>

            <div class="category-title-div">
                <h1>{{$author->title}}</h1>
            </div>


        @if($author->products->count()) 
        <div class="row category-list-product column-item-space">
            @php($di=0)
            @foreach($author->products as $authors)
            @php($di++)
            <div class="col-6 col-md-4 col-xl-3">
              <div class="grid_item">
                <figure>
                  <a href="{{route('product.detail', $authors->permalink)}}">
                    @if($authors->media)
                      {!!$authors->media->get_attachment('thumb_175')!!}
                    @endif
                  </a>
                  <div class="cart-add-btn cart-add-btn-replace">
                    <form method="POST" action="{{route('cart.add', $authors->id)}}" class="product-add-to-wishlist">
                      @csrf
                      <input type="hidden" id="product_{{$authors->id}}" name="product_quantity" class="form-control input-number text-center" value="1">
                      <button type="submit" class="add_to_cart_button"><span>Add to cart</span></button>
                    </form>
                  </div>
                </figure>
                <a href="{{route('product.detail', $authors->permalink)}}">
                  <h3>{{$authors->title}}</h3>
                </a>
                @if($authors->price)
                <div class="price_box">
                  <span class="new_price">NPR {{$authors->price}}</span>
                </div>
                @endif
                @if($authors->product_type)
                <div class="product_type_box">
                  <span class="product_type">{{$authors->product_type}}</span>
                </div>
                @endif
                <ul>
                  <li>
                    <a href="{{route('product.detail', $authors->permalink)}}" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Quick View">
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

            <!-- authors -->
            @if($authorlists->count()) 
            <div class="left-sidebar filter_categories sidebar-bottom-line">
              <h4 class="sidebar-title">Authors</h4>
              <ul>
              @foreach($authorlists as $authorlist)
                <li>
                  <a href="{{route('author.detail', $authorlist->permalink)}}"><span class="catTitle">{{$authorlist->title}}</span><span class="catCounter"> </span></a>
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
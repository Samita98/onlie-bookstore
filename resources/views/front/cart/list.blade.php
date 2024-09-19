@extends('front.common.main')
@section('contents')
<div class="py-4 bg-light cart-page">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          @php($cartcontents = Cart::getContent())
          <div class="card-header">
            <h3 class="mb-0">My Cart ({{$cartcontents->count()}})</h3>
          </div>
                
                @if(count($cartcontents))
          <div class="card-body">
                @php($i=0)
                @foreach($cartcontents as $row)
                  @php($i++)
                  <?php //print_r($row); ?>
                  <div class="cart-item">
                    <div class="row">
                        <div class="col-md-3">
                          @if($row->media)
                          {!!$row->media->get_attachment('thumb')!!}
                          @endif
                          <form method="POST" action="{{route('cart.update', $row->id)}}">
                      @csrf
                            <div class="button-quantity">
                              <button class="button-quantity-add btn-number" type="button" data-type="minus" data-field="cart_{{$i}}"> – </button>
                              <div class="button-quantity-input"><input type="text" value="{{$row->quantity}}" id="cart_{{$i}}" class="input-number" min="1" max="10" data-submit="update" name="product_quantity"></div>
                              <button class="button-quantity-less btn-number" type="button" data-type="plus" data-field="cart_{{$i}}"> + </button>
                            </div>
                          </form>
                        </div>
                        <div class="col-md-6">                          
                            <h4><?php echo $row->name; ?></h4>
                            <span class="cart-brand-cat">
                            @if($row->category)
                              {{$row->category->title}}<br>
                            @endif
                            </span>
                            <h5>Rs. {{$row->price*$row->quantity}}</h5>

                            
                        </div>
                        <div class="col-md-3">
                          <a href="{{route('cart.remove', $row->id)}}" class="cart-remove-btn">Remove</a>
                        </div>
                    </div>
                  </div>
                @endforeach
          </div>
          <div class="card-footer text-right">
            <a class="btn btn-primary" href="{{url('checkout')}}">Proceed to Checkout</a>
          </div>

                @else
                  <div class="card-body p-4 text-center">No items in cart.</div>
                @endif
        </div>
      </div>
      <div class="col-md-4">
        @if(count($cartcontents))
        <div class="card cart-price-content">
          <div class="card-header">
            <h5>Price Detail</h5>
          </div>
          <div class="card-body">
            <table class="table table-borderless">
              <tbody>
                <tr>

                  <td>Price ({{count(Cart::getContent())}} items) </td>
                  <td class="text-right">Rs. {{Cart::getTotal()}}</td>
                </tr>
                <tr>
                  <td>Total Amount</td>
                  <td class="text-right">Rs. {{Cart::getTotal()}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
@extends('front.common.main')
@section('contents')
<div class="checkout-section">
<div class="container">
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h6>User Details</h6>
        <hr>
        <form class="row g-3" action="{{url('place-order')}}" method="post">
                {{csrf_field()}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

          @if(Auth::check())
          <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" placeholder="Name" required>
          </div>
                    <div class="col-md-6">
            <label for="email" class="form-label">Name</label>
            <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" placeholder="Email" required>
          </div>
          <div class="col-md-6">
            <label for="phone_no" class="form-label">Phone No</label>
            <input name="phone_no" type="text" value="{{ Auth::user()->phone_no }}" class="form-control" placeholder="Your phone_no" required>
          </div>
          
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          @endif
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h6>Product Details</h6>
        <hr>

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

      </div>
    </div>    
  </div>
</div>
</div>
</div>
@endsection
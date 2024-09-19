@extends('front/common/main')
@section('contents')
<section class="contact-page-title">
<div class="container">
    <h1>{{$page->title}}</h1>
</div>
</section>

<div class="container">
<div class="row">
<div class="col-md-12">
<div class="wrapper">
<div class="row no-gutters">
<div class="col-lg-8 col-md-7 order-md-last">
<div class="contact-wrap">
              <h3 class="mb-4">Get in touch</h3>
              <form class="row g-3" action="{{route('form.submit', 1)}}" method="POST">
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
                @if(Session::has('success_message'))
                <p class="alert alert-success">{{ Session::get('success_message') }}</p>
                @endif
                <div class="col-md-6">
                  <label for="firstname" class="form-label">First Name</label>
                  <input type="text" name="firstname" value="{{old('firstname')}}" class="form-control" placeholder="First Name">
                </div>
                <div class="col-md-6">
                  <label for="lastname" class="form-label">Last Name</label>
                  <input type="text" name="lastname" value="{{old('lastname')}}" class="form-control" placeholder="Last Name">
                </div>
                <div class="col-12">
                  <label for="email" class="form-label">Email</label>
                  <input name="email" type="email" value="{{old('email')}}" class="form-control" placeholder="Your Email">
                </div>
                <div class="col-12">
                  <label for="message" class="form-label">Message</label>
                  <textarea name="message" id="message" class="form-control" rows="4" placeholder="Your Message">{{old('message')}}</textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
</div>
</div>

<div class="col-lg-4 col-md-5">
<div class="info-wrap">
<h3>Let's get in touch</h3>
<p class="mb-4">We're open for any suggestion or just to have a chat</p>
<div class="contact-info-list d-flex">
<div class="icon">
  <i class="fa-solid fa-location-dot"></i>
</div>
<div class="text-contact">
<p><span>Address:</span> {{config('setting.location')}}</p>
</div>
</div>
<div class="contact-info-list d-flex">
<div class="icon">
<i class="fa-solid fa-phone"></i>
</div>
<div class="text-contact">
<p><span>Phone:</span> {{config('setting.mobile')}}</p>
</div>
</div>
<div class="contact-info-list d-flex">
<div class="icon">
<i class="fa-solid fa-envelope"></i>
</div>
<div class="text-contact">
<p><span>Email:</span> {{config('setting.pemail')}}</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

    <section class="map-section">
    <div class="map-location-iframe">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113032.64621395378!2d85.25609251320085!3d27.708942727046708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb198a307baabf%3A0xb5137c1bf18db1ea!2sKathmandu%2044600!5e0!3m2!1sen!2snp!4v1599572028559!5m2!1sen!2snp" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    </section>
@endsection
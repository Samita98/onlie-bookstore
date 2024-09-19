@extends('front.common.main')
@section('contents')
<section class="section-login">

<div class="wrap-login-form">
<div class="login-form-bg" style="background-image: url(../images/bg-img.jpg);">
<span class="login-form-title">
Sign In
</span>
</div>

<div class="user-login-form">
<form method="POST" action="{{ route('login') }}">
  @if (session('error_message'))
      <div class="alert alert-danger">
          {{ session('error_message') }}
      </div>
  @endif
  @csrf
  <div class="row mb-3">
    <label for="email" class="col-sm-2 col-form-label">{{ __('E-Mail') }}</label>
    <div class="col-sm-10">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="example@example.com">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
  </div>
  <div class="row mb-3">
    <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
    <div class="col-sm-10">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-sm-10 offset-sm-2">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

        <label class="form-check-label" for="remember">
            {{ __('Remember Me') }}
        </label>
      </div>
    </div>
  </div>
  <div class="col-sm-10 offset-sm-2">
  <button type="submit" class="btn login-form-btn">{{ __('Login') }}</button>
  <br>
  <p>Don't have an account <a href="{{route('register')}}">Register Now</a></p>
  </div>
</form>
</div>
</div>
</section>
@endsection

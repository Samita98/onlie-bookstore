@extends('user.common.main')
@section('body')
<div class="card">
    <div class="card-header">
    <h2>User profile</h2>
    </div>
    <div class="Vendor-form card-body">
    @if(@$profile)
    <form method="POST" action="{{ route('user.profile.update', $profile->id) }}">
      @else
      <form method="POST" action="{{ route('user.profile.store') }}">
      @endif
      @csrf
      @if(Session::has('success_message'))
          <p class="alert alert-success">{{ Session::get('success_message') }}</p>
      @endif
      <div class="user-detail-tab row g-3">
        <div class="col-lg-6">
        <label for="title" class="col-form-label text-md-right">{{ __('Name') }}</label>
          <input type="text" name="name" value="{{ old('name', @$profile->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
          @error('name')
          <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="form-group col-lg-6">
        <label for="title" class="col-form-label text-md-right">{{ __('User login email') }}</label>
          <input type="email" name="email" value="{{ old('email', @$profile->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Company email">
          @error('email')
          <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="form-group col-lg-6">
        <label for="title" class="col-form-label text-md-right">{{ __('Phone number') }}</label>
          <input type="text" name="phone_no" value="{{ old('phone_no', @$profile->phone_no) }}" class="form-control @error('phone_no') is-invalid @enderror" placeholder="Phone number">
          @error('phone_no')
          <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="form-group col-lg-6">
        <label for="title" class="col-form-label text-md-right">{{ __('WhatApp') }}</label>
          <input type="text" name="whatsapp_no" value="{{ old('whatsapp_no', @$profile->whatsapp_no) }}" class="form-control @error('whatsapp_no') is-invalid @enderror" placeholder="WhatsApp number">
          @error('whatsapp_no')
          <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>
      <div class="row mt-3">
          <div class="col-lg-6 ">
              <button type="submit" class="btn btn-primary">
                  {{ __('Submit') }}
              </button>
          </div>
      </div>
    </form>

    </div>
</div>
@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('.multiselect').select2();
</script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': "{{csrf_token()}}"
    }
});
</script>
@endpush
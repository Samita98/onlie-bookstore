@extends('admin.common.main')
@section('contents')
@if(isset($user))
      <form method="post" action="{{route('admin.admin.update', $user->id)}}">
      <input name="_method" type="hidden" value="PUT">  
      @else
        <form method="post" action="{{route('admin.admin.store')}}">
      @endif
      @csrf
<div class="card">
  <div class="card-header bg-white">
    <h4 class="mb-0 p-2 font-weight-bolder">Admin User</h4>
  </div>
  <div class="card-body">
    
            <div style="opacity: 0;height: 0;overflow: hidden;">
                <input type="text" >
                <input type="password" >
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Feature Image</label>
                      <div class="thumbnail-container clearfix">
                        <button type="button" class="btn btn-xs btn-danger clear-media">&times;</button>
                        <a  class="media-open waves-effect waves-light btn btn-sm btn-primary" href="javascript:void(0)" data-for="thumbnail" data-type="input" data-modal-caption="Featured Image">Choose Image</a>
                        <input id="thumbnail" name="media_id" value="<?php echo @$user->media_id;?>" type="hidden">
                      <div id="thumbnail_preview" class="media-image-content">
                        @if(@$user->media)
                          {!!@$user->media->get_attachment()!!}
                        @endif
                      </div>
                      </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input class="form-control" type="text" name="name" value="{{@$user->name}}" id="fullname">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email Address</label>
                        <input class="form-control" type="email" name="email" value="{{@$user->email}}" id="Email">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label><br>
                        <select class="custom-select" name="role">
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" autocomplete="false" >
                    </div>
                </div>
            </div>
  </div>
    <div class="card-footer bg-white mt-4">
        <button class="btn btn-primary">Submit</button>
    </div>
</div>
        </form>
@endsection
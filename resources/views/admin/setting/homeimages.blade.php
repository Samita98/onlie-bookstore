@extends('admin.common.main')
@section('contents')
<div class="card">
  <div class="card-header">
      <h2 class="pageheader-title">Site Images</h2>
    </div>
  <div class="card-body">

      <form method="POST" action="{{route('admin.setting.homeimages_store')}}">
      {{csrf_field()}}

          <div class="nav-tabs-custom">
            <div class="tab-content m-t-10">
                <div class="tab-pane active" id="information">
                <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">

                <h3>Site Logo</h3>
                      <div class="thumbnail-container clearfix">
                        <button type="button" class="btn btn-xs btn-danger clear-media">&times;</button>
                        <a  class="media-open waves-effect waves-light btn btn-sm btn-primary" href="javascript:void(0)" data-for="thumbnail" data-type="input" data-modal-caption="Website Logo">Choose Image</a>
                        <input id="thumbnail" name="logo" value="{{@config('setting.logo')}}" type="hidden">
                      <div id="thumbnail_preview" class="media-image-content">
                        @if(config('setting.logo'))
                          {!!get_attachment(config('setting.logo'))!!}
                        @endif
                      </div>
                      </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <h3>Parallax Image</h3>
                      <div class="thumbnail-container clearfix">
                        <button type="button" class="btn btn-xs btn-danger clear-media">&times;</button>
                        <a  class="media-open waves-effect waves-light btn btn-sm btn-primary" href="javascript:void(0)" data-for="firstthumbnail" data-type="input" data-modal-caption="Featured Image">Choose Image</a>
                        <input id="firstthumbnail" name="firstparallax" value="{{@config('setting.firstparallax')}}" type="hidden">
                      <div id="firstthumbnail_preview" class="media-image-content">
                        @if(config('setting.firstparallax'))
                          {!!get_attachment(config('setting.firstparallax'))!!}
                        @endif
                      </div>
                      </div>
                  </div>
                </div>
                </div>
            </div>
            <!-- /.tab-content -->
            <div class="box-footer clearfix mt-4">
              <ul class="list-inline">
                <li><button onclick="needToConfirm = false" type="submit" value="submit" name="SubmitBtn" class="btn btn-success">Submit</button></li>
              </ul>
            </div>
            </div> 
    </form>
  </div>
</div>
@stop
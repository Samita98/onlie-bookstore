@extends('admin.common.main')
@section('contents')
<div class="card">
  <div class="card-header">
      <h2 class="pageheader-title">Slider Detail</h2>
    </div>
  <div class="card-body">

      @if(isset($slider))
      <form method="post" action="{{route('admin.slider.update', $slider->id)}}">
      <input name="_method" type="hidden" value="PUT">  
      @else
        <form method="post" action="{{route('admin.slider.store')}}">
      @endif

      {{csrf_field()}}

          <div class="nav-tabs-custom">
            <div class="tab-content m-t-10">
                <div class="tab-pane active" id="information">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <label class="form-label">Title</label>
                              <input value="{{@$slider->title}}" id="title" name="title" class="form-control" type="text">
                          </div>
                      </div>

                <label>Feature Image</label>
                      <div class="thumbnail-container clearfix">
                        <button type="button" class="btn btn-xs btn-danger clear-media">&times;</button>
                        <a  class="media-open waves-effect waves-light btn btn-sm btn-primary" href="javascript:void(0)" data-for="thumbnail" data-type="input" data-modal-caption="Featured Image">Choose Image</a>
                        <input id="thumbnail" name="image" value="<?php echo @$slider->image;?>" type="hidden">
                      <div id="thumbnail_preview" class="media-image-content">
                        @if(@$slider->media)
                          {!!@$slider->media->get_attachment()!!}
                        @endif
                      </div>
                      </div>
                    </div>
                  <div class="col-md-6 col-sm-12 col-xs-12 top-20">

                        <label for="caption">Caption</label><br>
                        <textarea id="caption" name="caption" class="form-control">{{@$slider->caption}}</textarea>
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
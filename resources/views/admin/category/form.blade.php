@extends('admin.common.main')
@section('contents')
<div class="card">
  <div class="card-header">
    <h4 class="mb-0 p-2 font-weight-bolder">Category Detail
    @if(isset($category))
    <a class="btn btn-success waves-effect waves-light ml-4" href="{{url($category->permalink)}}" target="_blank">View Category</a>
      <a class="btn btn-primary waves-effect waves-light ml-2" href="{{route('admin.category.create')}}">Add Category</a>
    @endif
                  </h4>
  </div>
  <div class="card-body">
      @if(isset($category))
      <form method="post" action="{{route('admin.category.update', $category->id)}}">
      <input name="_method" type="hidden" value="PUT">  
      @else
        <form method="post" action="{{route('admin.category.store')}}">
      @endif
      {{csrf_field()}}

          <div class="tab-regular">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" href="#information" data-toggle="tab" aria-expanded="true">Information</a></li>
              <li class="nav-item"><a class="nav-link" href="#images" data-toggle="tab" aria-expanded="true">Images</a></li>
              <li class="nav-item"><a class="nav-link" href="#meta_information" data-toggle="tab" aria-expanded="true">Meta Information</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="information">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <label class="form-label">Title</label>
                              <input value="{{@$category->title}}" id="title" name="title" class="form-control" type="text">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group form-float">
                      <div class="form-line">
                          <label class="form-label">Permalink</label>
                          <input id="permalink" value="{{@$category->permalink}}" name="permalink" class="form-control" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="form-label">Parent Category</label><br>
                      <select name="parent_id" class="form-control">
                        <option value="0">Select</option>
                        {!!$parent_items!!}
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 top-20">
                    <label for="description">Description</label><br>
                    <textarea id="description" name="detail" class="WYSWIYG large">{!!@$category->detail!!}</textarea>
                  </div>
                </div>
                </div>
                <div class="tab-pane" id="images">
                  <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Feature Image <small>(Image is only for the thumbnail)</small></label>
                    <div class="thumbnail-container clearfix">
                      @if(@$category->media)
                    <button type="button" class="btn btn-sm btn-success edit-media-alt-name waves-effect waves-light" onclick="return on_click_media_edit(this, '{{@$category->media->alt}}', '{{$category->image}}');">Edit Media</button>
                    @endif
                      <button type="button" class="btn btn-xs btn-danger clear-media">&times;</button>
                      <a  class="media-open waves-effect waves-light btn btn-sm btn-primary" href="javascript:void(0)" data-for="thumbnail" data-type="input" data-modal-caption="Featured Image">Choose Image</a>
                      <input id="thumbnail" name="image" value="<?php echo @$category->image;?>" type="hidden">
                      <div id="thumbnail_preview" class="media-image-content">
                        @if(@$category->media)
                          {!!@$category->media->get_attachment()!!}
                        @endif
                      </div>
                    </div>
                    </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Icon</label>
                    <div class="thumbnail-container clearfix">
                      <button type="button" class="btn btn-xs btn-danger clear-media">&times;</button>
                      <a  class="media-open waves-effect waves-light btn btn-sm btn-primary" href="javascript:void(0)" data-for="icon" data-type="input" data-modal-caption="Featured Image">Choose Image</a>
                      <input id="icon" name="icon" value="<?php echo @$category->icon;?>" type="hidden">
                      <div id="icon_preview" class="media-image-content">
                        
                        @if(@$category->icon)
                            {!!get_attachment(@$category->icon, 'thumb')!!}
                        @endif
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="meta_information">
                  <div class="row">

                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="meta_title">Meta Title</label>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea rows="3" class="form-control no-resize" name="meta_title" id="meta_title">{{@$category->meta_title}}</textarea>
                        </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <label for="meta_description">Meta Description</label>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea rows="3" class="form-control no-resize" name="meta_description" id="meta_description">{{@$category->meta_description}}</textarea>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <label for="meta_keyword">Meta Keyword</label>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea rows="3" name="meta_keyword" id="meta_keyword" class="form-control no-resize" >{{@$category->meta_keyword}}</textarea>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="meta_robot">Meta Robot</label><br>
                    <select name="meta_robot" id="meta_robot" class="form-control show-tick ms">
                      <?php $meta_robots = array('index, follow', 'index, nofollow', 'noindex, follow', 'noindex, nofollow');
                      foreach ($meta_robots as $key ) { ?>
                        <option value="<?php echo $key; ?>" <?php if($key==@$category->meta_robot) echo 'selected="selected"'; ?>><?php echo $key; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-content -->
            <div class="box-footer clearfix mt-3">
              <ul class="list-inline">
                <li><button onclick="needToConfirm = false" type="submit" value="submit" name="SubmitBtn" class="btn btn-success">Submit</button></li>
              </ul>
            </div>
            </div> 
    </form>
  </div>
</div>
@stop
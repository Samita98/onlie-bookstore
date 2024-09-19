@extends('admin.common.main')
@section('contents')
<div class="">
  <div class=" bg-white">
    <h4 class="mb-0 p-2 font-weight-bolder">Product Detail</h4>
  </div>
  <div class="">
      @if(isset($product))
      <form method="post" action="{{route('admin.product.update', $product->id)}}">
      <input name="_method" type="hidden" value="PUT">  
      @else
        <form method="post" action="{{route('admin.product.store')}}">
      @endif

      {{csrf_field()}}

          <div class="tab-regular">
            <ul class="nav nav-tabs">
              <li class="nav-item active"><a class="nav-link " href="#information" data-toggle="tab" aria-expanded="true">Information</a></li>
              <li class="nav-item"><a class="nav-link" href="#images" data-toggle="tab"  aria-expanded="false">Product Images</a></li>
              <li class="nav-item"><a class="nav-link" href="#meta_information" data-toggle="tab" aria-expanded="false">Meta Information</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="information">
                  <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <label class="form-label">Title</label>
                              <input value="{{@$product->title}}" id="title" name="title" class="form-control" type="text" required="">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <label class="form-label">Permalink</label>
                              <input id="permalink" value="{{@$product->permalink}}" name="permalink" class="form-control" type="text">
                          </div>
                      </div>
                  </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group form-float">
                  <div class="form-line">
                    <label class="form-label">Price</label>
                    <input id="price" value="{{@$product->price}}" name="price" class="form-control" type="text" required="">
                  </div>
                </div>
              </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label class="form-label">Author</label><br>
                    <select name="author_id" class="form-control" required="">
                    <option value="0">Select author</option>
                      @foreach($authors as $author)
                        <option @if(@$product->author_id==$author->id) selected="" @endif value="{{$author->id}}">{{$author->title}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="form-label">Category</label><br>
                  <select name="category_id" class="form-control" required="">
                    <option value="0">Select category</option>
                    {!!$category_items!!}
                  </select>
                </div>
              </div>
            <div class="col-md-6">
              <div class="form-group">
              <label for="product_type" class="form-label">Product type</label><br>
                  <select name="product_type" class="form-control">
                          @php($product_types = array('New Books', 'Used Books'))
                          @foreach ($product_types as  $product_type)
                            <option {{($product_type==@$product->product_type) ? "selected" : ""}} value="{{$product_type}}">{{$product_type}}</option>
                          @endforeach
                  </select>
              </div>
            </div>

                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                    <label for="description">Description</label><br>
                    <textarea id="description" name="detail" class="WYSWIYG large">{!!@$product->detail!!}</textarea>
                  </div>
                </div>
                </div>

              <div class="tab-pane" id="images" role="tabpanel" aria-labelledby="images-tab">
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Featured Image</label>
                    <div class="col-md-6">
                      <div class="thumbnail-container clearfix">
                        <button type="button" class="btn btn-xs btn-danger clear-media">&times;</button>
                        <a  class="media-open waves-effect waves-light btn btn-sm btn-primary" href="javascript:void(0)" data-for="thumbnail" data-type="input" data-modal-caption="Featured Image">Choose Image</a>
                        <input id="thumbnail" name="image" value="<?php echo @$product->image;?>" type="hidden">
                      <div id="thumbnail_preview" class="media-image-content">
                        @if(@$product->media)
                          {!!@$product->media->get_attachment()!!}
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
                            <textarea rows="3" class="form-control no-resize" name="meta_title" id="meta_title">{{@$product->meta_title}}</textarea>
                        </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <label for="meta_description">Meta Description</label>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea rows="3" class="form-control no-resize" name="meta_description" id="meta_description">{{@$product->meta_description}}</textarea>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <label for="meta_keyword">Meta Keyword</label>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea rows="3" name="meta_keyword" id="meta_keyword" class="form-control no-resize" >{{@$product->meta_keyword}}</textarea>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="meta_robot">Meta Robot</label><br>
                    <select name="meta_robot" id="meta_robot" class="form-control show-tick ms">
                      <?php $meta_robots = array('index, follow', 'index, nofollow', 'noindex, follow', 'noindex, nofollow');
                      foreach ($meta_robots as $key ) { ?>
                        <option value="<?php echo $key; ?>" <?php if($key==@$product->meta_robot) echo 'selected="selected"'; ?>><?php echo $key; ?></option>
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
@extends('user.common.main')
@section('body')
<div class="card">
	<div class="card-header">
		<h4 class="card-title mb-0">@if(@$product) Edit Product @else Add Product @endif</h4>
	</div>
	<div class="card-body">
		@if(@$product)
		<form method="POST" action="{{ route('user.product.update', $product->id) }}">
		@else
		<form method="POST" action="{{ route('user.product.store') }}">
		@endif
            @csrf
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
            <div class="product-detail-tab">
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="information-tab" data-bs-toggle="tab" data-bs-target="#information" type="button" role="tab" aria-controls="information" aria-selected="true">Information</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="true">Product Images</button>
              </li>
            </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab" tabindex="0">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="title" class="form-label">Title</label>
              <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', @$product->title) }}" placeholder="Enter title" required autofocus>
            </div>
            <div class="col-md-6">
              <label for="price" class="form-label">Price</label>
              <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', @$product->price) }}" placeholder="Enter product price in NPR" required >
            </div>
            <div class="col-md-6">
              <label for="author_id" class="form-label">Author</label>
              <select id="author_id" type="text" class="form-select" name="author_id" required >
                  <option value="">-----Select author-----</option>
                @foreach($authors as $author)
                  <option @if(old('author_id', @$product->author_id)==$author->id) selected="" @endif value="{{$author->id}}">{{$author->title}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="category_id" class="form-label">Category</label>
              <select id="category_id" type="text" class="form-select" name="category_id" required >
                  <option value="">-----Select product category-----</option>
                @foreach($categories as $category)
                  <option @if(old('category_id', @$product->category_id)==$category->id) selected="" @endif value="{{$category->id}}">{{$category->title}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="product_type" class="form-label">Product type</label>
                  <select name="product_type" class="form-select">
                          @php($product_types = array('New Books', 'Used Books'))
                          @foreach ($product_types as  $product_type)
                            <option {{($product_type==@$product->product_type) ? "selected" : ""}} value="{{$product_type}}">{{$product_type}}</option>
                          @endforeach
                  </select>
            </div>

            <div class="col-md-12">
              <label for="description" class="form-label">Description</label>
              <textarea id="detail" class="form-control WYSWIYG @error('detail') is-invalid @enderror" name="detail" rows="5" placeholder="Enter product details with maximum 500 character">{{ old('detail', @$product->detail) }}</textarea>
            </div>
          </div>
          </div>

          
          <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab" tabindex="0">
                <div class="form-group">
                    <label class="col-form-label text-md-right">Featured image</label>
                    <div class="col-lg-6">
                    <div class="thumbnail-container clearfix">
                          <button type="button" class="btn btn-xs btn-danger clear-media">&times;</button>
                          <a  class="media-open waves-effect waves-light btn btn-sm btn-primary" href="javascript:void(0)" data-for="thumbnail" data-type="input" data-modal-caption="Featured Image">Choose image</a>
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

        </div>



            <div class="row mt-3">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>
          </div>
        </form>
	</div>
</div>






<div class="modal fade" id="MediaModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row w-100">
            <div class="col-md-2">
                <h4 class="modal-title">Media</h4>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body" id="AllMediaContainer">
            <input type="file" multiple="multiple" name="files[]" id="media_uploader">
      </div>
      <div class="modal-footer">
        <button type="button" class="waves-effect waves-dark btn btn-default" data-bs-dismiss="modal">Close</button>
        <button type="button" class="waves-effect waves-dark btn btn-primary" id="SelectAndInsertMedia">Insert</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="MediaEditModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="row">
                    <div class="col-md-10">
                        <h4 class="modal-title">Edit Media</h4>
                    </div>
                </div>
            </div>
            <div class="modal-body" id="MediaEditBody">
                <form id="MediaEditForm">
                    {{csrf_field()}}
                    <input type="hidden" name="mediaid" id="MediaIdForEdit">
                    <input type="hidden" name="action" value="edit_media_with_filename">
                    <div class="form-group form-float">
                      <div class="form-line focused">
                          <input value="" id="main_media_title" name="main_media_title" class="form-control" type="text">
                          <label class="form-label">Title / Alt</label>
                      </div>
                    </div>
                    <div class="form-group form-float">
                      <div class="form-line">
                          <input value="" id="main_media_file_name" name="main_media_file_name" class="form-control" type="text">
                          <label class="form-label">File name</label>
                      </div>
                    </div>
                    <button type="button" class="waves-effect waves-dark btn btn-primary" id="UpdateAltInMedia">Update</button>
                </form>
            </div>
        <div class="modal-footer">
            <button type="button" class="waves-effect waves-dark btn btn-default" data-bs-dismiss="modal">Close</button>
        </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('.multiselect').select2();
</script>
<script type="text/javascript" src="{{url('admin-assets/vendors/tinymce/tinymce.min.js')}}"></script>

<script type="text/javascript"> var site_url = "{{url('/')}}"; var site_token = "{{csrf_token()}}"; </script>
<script type="text/javascript">
    var files= {!!App\Model\Media::get_user_attachment()!!};
</script>

<script type="text/javascript">

tinymce.init({
    selector: ".WYSWIYG",
    height: 480,
    relative_urls : false,
    browser_spellcheck: true,
    branding: false,
    paste_as_text: true,
    plugins: [
        'advlist pageembed autolink lists charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime nonbreaking save table contextmenu directionality',
        'template paste textcolor colorpicker textpattern'
    ],
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist',
    toolbar2: 'forecolor backcolor'
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': "{{csrf_token()}}"
    }
});
</script>
@endpush
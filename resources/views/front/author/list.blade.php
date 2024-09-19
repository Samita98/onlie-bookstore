@extends('front/common/main')
@section('contents')

<section class="section-wrap pt-60 pb-30 catalog">
      <div class="container">
        <div class="">
          <div class="author-list-section">
            <div class="author-title-div">
                <h1>Author</h1>
            </div>

            @if($author->count()) 
              <div class="row column-item-space">
                  @php($di=0)
                  @foreach($author as $authors)
                  @php($di++) 
                <div class="col-md-2 space-between-author">
                  <a href="{{route('author.detail', $authors->permalink)}}">
                  <div class="author-bg">
                  @if($authors->media)
                      {!!$authors->media->get_attachment('')!!}
                  @endif
                  </div>
                  <div class="author-name">
                    <h3>{{$authors->title}}</h3>
                  </div>
                  </a>
                </div>
                @endforeach
              </div><!-- end row -->
              @endif
          </div> <!-- end col -->

    </div> <!-- end row -->
  </div> <!-- end container -->
</section>
@endsection
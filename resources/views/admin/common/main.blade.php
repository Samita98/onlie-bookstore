<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title ?? env('app_name')}}</title>
    
    
    <link rel="stylesheet" type="text/css" href="{{url('admin-assets/vendors/jqueryui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
    <!-- vendor css -->
    <link rel="stylesheet" href="{{url('admin-assets/vendors/jQuery.filer/css/jquery.filer.css')}}">
    <link rel="stylesheet" href="{{url('admin-assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{url('admin-assets/css/bootstrap-override.css')}}">
<link rel="stylesheet" href="{{url('admin-assets/css/weather-icons.min.css')}}">
<link rel="stylesheet" href="{{url('admin-assets/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{url('admin-assets/css/animate.min.css')}}">
<link rel="stylesheet" href="{{url('admin-assets/css/animate.delay.css')}}">
<link rel="stylesheet" href="{{url('admin-assets/css/toggles.css')}}">
    <link rel="stylesheet" href="{{url('admin-assets/css/style.css')}}">
    <link rel="stylesheet" href="{{url('admin-assets/css/custom.css')}}">

    <script type="text/javascript"> var site_url = "{{url('/')}}"; var site_token = "{{csrf_token()}}"; </script>
    <script type="text/javascript">
        var files= {!!App\Model\Media::get_all_attachment()!!};
    </script>
</head>
<body class="">

    <div class="headerwrapper">
        <div class="header-left">
            <a href="{{route('admin.dashboard')}}" class="logo">
                {{$title ?? env('app_name')}}
            </a>
            <div class="pull-right">
                <a href="" class="menu-collapse">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div><!-- header-left -->
        <div class="header-right">
        <a href="{{url('/')}}" target="_blank" class="btn btn-warning waves-effect waves-light m-l-5 m-t-10">Visit Site</a>
        <div class="pull-right">
        <a class="btn btn-default" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"> </i> Sign Out</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        </div>
        </div>
       
    </div><!-- headerwrapper -->
</header>

         <section>
            <div class="mainwrapper">
                <div class="leftpanel">
                    <div class="media profile-left">
                        <a class="pull-left profile-thumb" href="{{route('admin.admin.edit', Auth::user()->id)}}">
              @if(Auth::guard('admin')->user()->media)
                <img src="{!!Auth::guard('admin')->user()->media->get_attachment_url('thumb')!!}" alt="user-image" class="img-circle">
              @else
              <img src="{{url('admin-assets/images/avatar.jpg')}}" alt="user-image" class="img-circle">
              @endif
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{{Auth::guard('admin')->user()->name}}</h4>
                            <small class="text-muted">Administrator</small>
                        </div>
                    </div><!-- media -->
                    
                    <h5 class="leftpanel-title">Navigation</h5>
                    <ul class="nav nav-pills nav-stacked">
                        <li class="@if(Route::is('admin.dashboard')) active @endif"><a href="{{route('admin.dashboard')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                        <li class="@if(Route::is('admin.media.*')) active @endif"><a href="{{route('admin.media.index')}}"><i class="fa fa-image"></i> <span>Media</span></a></li>
                        
                        <li class="parent @if(Route::is('admin.slider.*')) active @endif">
                            <a href="#"><i class="fa fa-sliders"></i> <span>Slider</span></a>
                            <ul class="children">
                                <li class="@if(Route::is('admin.slider.index')) active @endif"><a href="{{route('admin.slider.index')}}">All Sliders</a></li>
                                <li class="@if(Route::is('admin.slider.create')) active @endif"><a href="{{route('admin.slider.create')}}">Add Slider</a></li>
                            </ul>
                        </li>
                        <li class="parent @if(Route::is('admin.page.*')) active @endif">
                            <a href="#"><i class="fa fa-file"></i> <span>Page</span></a>
                            <ul class="children">
                                <li class="@if(Route::is('admin.page.index')) active @endif"><a href="{{route('admin.page.index')}}">All Pages</a></li>
                                <li class="@if(Route::is('admin.page.create')) active @endif"><a href="{{route('admin.page.create')}}">Add Page</a></li>
                            </ul>
                        </li>
                        <li class="parent @if(Route::is('admin.product.*') || Route::is('admin.category.*') || Route::is('admin.author.*')) active @endif">
                            <a href="#"><i class="fa fa-shopping-cart"></i> <span>Product</span></a>
                            <ul class="children">
                                <li class="@if(Route::is('admin.product.index')) active @endif"><a href="{{route('admin.product.index')}}">Product</a></li>
                                <li class="@if(Route::is('admin.category.*')) active @endif"><a href="{{route('admin.category.index')}}">Category</a></li>
                                <li class="@if(Route::is('admin.author.*')) active @endif"><a href="{{route('admin.author.index')}}">Author</a></li>
                            </ul>
                        </li>
                        <li class="@if(Route::is('admin.user.index')) active @endif"><a href="{{route('admin.user.index')}}"><i class="fa fa-user"></i> User list</a></li>

                        <li class="@if(Route::is('admin.menu.*')) active @endif">
                        <a href="{{route('admin.menu.index')}}">
                        <i class="fa fa-bars"></i> <span>Manage Menu</span>
                        </a>
                        </li>
                        <li class="parent @if(Route::is('admin.setting.*')) active @endif">
                            <a href="#"><i class="fa fa-cogs"></i> <span>Setting</span></a>
                            <ul class="children">
                                <li class="@if(Route::is('admin.setting.home')) active @endif"><a href="{{route('admin.setting.home')}}">Home Configuration</a></li>
                                <li class="@if(Route::is('admin.setting.index')) active @endif"><a href="{{route('admin.setting.index')}}">Site Configuration</a></li>
                                <li class="@if(Route::is('admin.setting.homeimages')) active @endif"><a href="{{route('admin.setting.homeimages')}}">Site Images</a></li>
                                </ul>
                        </li>
                        <li class="parent @if(Route::is('admin.admin.*')) active @endif">
                            <a href="#" ><i class="fa fa-user"></i><span>All Users</span></a>
                            <ul class="children">
                                <li class="@if(Route::is('admin.admin.index')) active @endif"><a href="{{route('admin.admin.index')}}">All Users</a></li>
                                <li class="@if(Route::is('admin.admin.create')) active @endif"><a href="{{route('admin.admin.create')}}">Add User</a></li>
                            </ul>
                        </li>
                    </ul>
                    
                </div><!-- leftpanel -->
                
                <div class="mainpanel">
    
                    
                    <div class="contentpanel">
                        
                        @if(Session::has('success_message'))
       <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {{ Session::get('success_message') }}
        </div>
@endif

      
          @yield('contents')
                        
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>
        
        
        

        
         
           <script src="{{url('admin-assets/js/jquery-1.11.1.min.js')}}"></script>
        <script src="{{url('admin-assets/js/jquery-migrate-1.2.1.min.js')}}"></script>
        <script src="{{url('admin-assets/js/bootstrap.min.js')}}"></script>
        
        
        <script src="{{url('admin-assets/js/morris.min.js')}}"></script>
        
<script type="text/javascript" src="{{url('admin-assets/vendors/jQuery.filer/js/jquery.filer.min.js')}}"></script>
<script type="text/javascript" src="{{url('admin-assets/vendors/jqueryui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{url('admin-assets/vendors/tinymce/tinymce.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg==" crossorigin="anonymous"></script>
    <script src="{{url('admin-assets/vendors/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{url('admin-assets/js/custom.js')}}"></script>

 

    <script>
        
        jQuery(document).ready(function() {
   
   "use strict";
   
   // Tooltip
   jQuery('.tooltips').tooltip({ container: 'body'});
   
   // Popover
   jQuery('.popovers').popover();
   
   // Show panel buttons when hovering panel heading
   jQuery('.panel-heading').hover(function() {
      jQuery(this).find('.panel-btns').fadeIn('fast');
   }, function() {
      jQuery(this).find('.panel-btns').fadeOut('fast');
   });
   
   // Close Panel
   jQuery('.panel .panel-close').click(function() {
      jQuery(this).closest('.panel').fadeOut(200);
      return false;
   });
   
   // Minimize Panel
   jQuery('.panel .panel-minimize').click(function(){
      var t = jQuery(this);
      var p = t.closest('.panel');
      if(!jQuery(this).hasClass('maximize')) {
         p.find('.panel-body, .panel-footer').slideUp(200);
         t.addClass('maximize');
         t.find('i').removeClass('fa-minus').addClass('fa-plus');
         jQuery(this).attr('data-original-title','Maximize Panel').tooltip();
      } else {
         p.find('.panel-body, .panel-footer').slideDown(200);
         t.removeClass('maximize');
         t.find('i').removeClass('fa-plus').addClass('fa-minus');
         jQuery(this).attr('data-original-title','Minimize Panel').tooltip();
      }
      return false;
   });
   
   jQuery('.leftpanel .nav .parent > a').click(function() {
      
      var coll = jQuery(this).parents('.collapsed').length;
      
      if (!coll) {
         jQuery('.leftpanel .nav .parent-focus').each(function() {
            jQuery(this).find('.children').slideUp('fast');
            jQuery(this).removeClass('parent-focus');
         });
         
         var child = jQuery(this).parent().find('.children');
         if(!child.is(':visible')) {
            child.slideDown('fast');
            if(!child.parent().hasClass('active'))
               child.parent().addClass('parent-focus');
         } else {
            child.slideUp('fast');
            child.parent().removeClass('parent-focus');
         }
      }
      return false;
   });
   
   
   // Menu Toggle
   jQuery('.menu-collapse').click(function() {
      if (!$('body').hasClass('hidden-left')) {
         if ($('.headerwrapper').hasClass('collapsed')) {
            $('.headerwrapper, .mainwrapper').removeClass('collapsed');
         } else {
            $('.headerwrapper, .mainwrapper').addClass('collapsed');
            $('.children').hide(); // hide sub-menu if leave open
         }
      } else {
         if (!$('body').hasClass('show-left')) {
            $('body').addClass('show-left');
         } else {
            $('body').removeClass('show-left');
         }
      }
      return false;
   });
   
   // Add class nav-hover to mene. Useful for viewing sub-menu
   jQuery('.leftpanel .nav li').hover(function(){
      $(this).addClass('nav-hover');
   }, function(){
      $(this).removeClass('nav-hover');
   });
   
   // For Media Queries
   jQuery(window).resize(function() {
      hideMenu();
   });
   
   hideMenu(); // for loading/refreshing the page
   function hideMenu() {
      
      if($('.header-right').css('position') == 'relative') {
         $('body').addClass('hidden-left');
         $('.headerwrapper, .mainwrapper').removeClass('collapsed');
      } else {
         $('body').removeClass('hidden-left');
      }
      
      // Seach form move to left
      if ($(window).width() <= 360) {
         if ($('.leftpanel .form-search').length == 0) {
            $('.form-search').insertAfter($('.profile-left'));
         }
      } else {
         if ($('.header-right .form-search').length == 0) {
            $('.form-search').insertBefore($('.btn-group-notification'));
         }
      }
   }
   
   collapsedMenu(); // for loading/refreshing the page
   function collapsedMenu() {
      
      if($('.logo').css('position') == 'relative') {
         $('.headerwrapper, .mainwrapper').addClass('collapsed');
      } else {
         $('.headerwrapper, .mainwrapper').removeClass('collapsed');
      }
   }

});
    </script>
    

<div class="modal fade" id="MediaModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row w-100">
            <div class="col-md-2">
                <h4 class="modal-title">Media</h4>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="MediaKeyword" placeholder="Search">
            </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="AllMediaContainer">
            <input type="file" multiple="multiple" name="files[]" id="media_uploader">
      </div>
      <div class="modal-footer">
        <button type="button" class="waves-effect waves-dark btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="waves-effect waves-dark btn btn-primary" id="SelectAndInsertMedia">Insert</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="MediaEditModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                        <label class="form-label">File Name</label>
                    </div>
                  </div>
                  <button type="button" class="waves-effect waves-dark btn btn-primary" id="UpdateAltInMedia">Update</button>
              </form>
          </div>
      <div class="modal-footer">
          <button type="button" class="waves-effect waves-dark btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
<script type="text/javascript">

tinymce.init({
    selector: ".WYSWIYG",
    height: 480,
    setup : media_editor_setups,
    relative_urls : false,
    browser_spellcheck: true,
    branding: false,
    paste_as_text: true,
    plugins: [
        'advlist pageembed autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'template paste textcolor colorpicker textpattern'
    ],
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: ' media | forecolor backcolor | mybutton'
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': "{{csrf_token()}}"
    }
});
</script>
</body>
</html>
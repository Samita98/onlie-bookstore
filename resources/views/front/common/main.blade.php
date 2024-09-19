<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{$title ?? env('APP_NAME')}}</title>

<!-- Bootstrap -->
    <link href="{{url('fontawesome/css/all.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/style.css')}}">


    <link rel="stylesheet" href="{{url('admin-assets/vendors/jQuery.filer/css/jquery.filer.css')}}">
    <link rel="stylesheet" href="{{url('css/userdb.css')}}">


</head>

<body>

<header class="header_section">
<div class="main_header">
  <div class="container">
  <div class="row">
    <div class="col-lg-3 col-md-3 col-xs-3 col-3 align-self-center">
        <a class="navbar-brand" href="{{url('/')}}">
          @if(config('setting.logo'))
            {!!get_attachment(config('setting.logo'))!!}
          @endif
        </a> 
    </div>
    <div class="col-lg-5 col-md-5 col-xs-5 col-6 align-self-center">
      <div class="custom-search-input">
      <form class="d-flex form-search" method="GET" action="{{route('search')}}">
        <input id="TopKeywordSearch" class="form-control me-2" type="search" name="keyword" placeholder="Search Books..." aria-label="Search">
        <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> 
      </form>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-xs-4 col-3 align-self-center">
    <div class="header-login-signup-cart">
      <div class="row">
      <div class="col-md-4 header-shopping-card align-self-center">
        <span class="cart-icon">
          <a href="{{route('cart.view')}}" class=""><i class="fas fa-shopping-cart fa-2x"></i> ({{Cart::getContent()->count()}})</a>
        </span>
      </div>
      @guest
      <div class=" col-md-8 account-login-signup">
        <span class="login-icon">
          <a href="{{route('login')}}" class="user-login-btn"> Login</a>
        </span> 
        <span class="signup-icon">
          <a href="{{route('register')}}" class="user-sign-up-btn"> SignUp</a>
        </span>
      </div>
      @else
      <div class="col-md-4 offset-md-4 user-account-name">
      <ul class="navbar-nav me-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="{{route('user.profile.edit')}}">Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}"
             onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
      </div>
      @endguest
      </div>
    </div>
    </div>
  </div>
  </div>
</div>

<div class="second_head_nav second_head_sticky">
      <div class="container">
        <div class="row small-gutters">
          <div class="col-xl-3 col-lg-3 col-md-3 align-self-center">
          <nav class="navbar navbar-expand-lg category-list-navbar">
            <div class="container-fluid">
              <div class="collapse navbar-collapse" id="navbarCategory">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle categories-title" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Categories
                    </a>
                    <ul class="dropdown-menu main-category top-category_list">
                    @php($categories = \App\Model\Category::where('parent_id', 0)->get())
                    @foreach($categories as $category)
                    <li class="dropdown-item"><a href="{{url('category', $category->permalink)}}">{{$category->title}}</a>
                    @if($category->children)
                    <ul class="sub-category">
                      @foreach($category->children as $child)
                      <li class="dropdown-item"><a href="{{url('category', $child->permalink)}}">{{$child->title}}</a></li>
                      @endforeach
                    </ul>
                    @endif
                    </li>
                    @endforeach
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
          </div>
          <div class="col-lg-9 align-self-center">
          <nav class="navbar navbar-expand-lg header-menu-list">
            <div class="container-fluid">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenuContent" aria-controls="navbarMenuContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarMenuContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 site-main-nav">
                  {!!\App\Model\Menu::getMenu(1)!!}
                </ul>
              </div>
            </div>
          </nav>
          </div>

        </div>
      </div>
    </div>
</header>

@yield('contents')

<footer class="footer-section">
  <div class="container">
    <div class="footer-area">
        <div class="ft__logo">
            <a href="{{url('/')}}">
                @if(config('setting.logo'))
                  {!!get_attachment(config('setting.logo'))!!}
                @endif
            </a>
            <p>There are many variations of passages of Lorem Ipsum available, but the majority
                have suffered duskam alteration variations of passages</p>
        </div>
        <div class="footer__content">
            <ul class="ft_social_links d-flex justify-content-center">
                <li><a href="{{config('setting.facebook')}}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="{{config('setting.twitter')}}" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="{{config('setting.instagram')}}" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="{{config('setting.youtube')}}" target="_blank"><i class="fa-brands fa-youtube"></i></a></li>
            </ul>
            <ul class="footer_menu d-flex justify-content-center">
                {!!\App\Model\Menu::getMenu(2)!!}
            </ul>
        </div>
    </div>
  </div>
</footer>

@prepend('scripts')

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="{{url('js/custom.js')}}"></script>

<script type="text/javascript">

$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("#"+fieldName);
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('id');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }

    var submitd = $(this).data('submit');
    if(submitd=='update'){
      $(this).closest('form').submit();
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    </script>
 
@endprepend
@stack('scripts')
</body>
</html>
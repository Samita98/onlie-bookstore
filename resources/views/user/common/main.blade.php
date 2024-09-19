@extends('front.common.main')
@section('contents')

@push('scripts')
<script type="text/javascript" src="{{url('admin-assets/vendors/jQuery.filer/js/jquery.filer.js')}}"></script>
<script type="text/javascript" src="{{url('js/userdb.js')}}"></script>

<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': "{{csrf_token()}}"
    }
});
</script>

@endpush
<div id="UserDashboard" class="py-5">
	<div class="container">
		<div class="row">
			<div class="col-md-3 user-db-side-row">
                <div class="dashboard-title">
                	<h2>User Dashboard</h2>
                </div>
				<ul class="dashboard-side-menu-bar">
				  <li class="">
				    <a class="" href="{{route('user.dashboard')}}">Dashboards</a>
				  </li>
                  <li class="">
				    <a class="" href="{{route('user.profile.edit')}}">User profile</a>
				  </li>
				  <li class="">
				    <a class="" href="{{route('user.product.create')}}">Add New Book</a>
				  </li>
				  <li class="">
				    <a class="" href="{{route('user.product.index')}}">My Products</a>
				  </li>

          
				  <li class="nav-item">
				  	<a class="nav-link" href="{{ route('logout') }}"
                 onclick="event.preventDefault();
                               document.getElementById('main-logout').submit();">
                  {{ __('Logout') }}
              </a>

              <form id="main-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
				  </li>
				</ul>
			</div>
			<div class="col-md-9">
				@yield('body')
			</div>
		</div>
	</div>
</div>
@endsection
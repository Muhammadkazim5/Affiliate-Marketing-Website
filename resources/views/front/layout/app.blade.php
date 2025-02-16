<!DOCTYPE html>
<html class="no-js" lang="en_AU" />

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Affiliate Marketing Website</title>
	<meta name="description" content="" />
	<meta name="viewport"
		content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />

	<meta property="og:locale" content="en_AU" />
	<meta property="og:type" content="website" />
	<meta property="fb:admins" content="" />
	<meta property="fb:app_id" content="" />
	<meta property="og:site_name" content="" />
	<meta property="og:title" content="" />
	<meta property="og:description" content="" />
	<meta property="og:url" content="" />
	<meta property="og:image" content="" />
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="" />
	<meta property="og:image:height" content="" />
	<meta property="og:image:alt" content="" />

	<meta name="twitter:title" content="" />
	<meta name="twitter:site" content="" />
	<meta name="twitter:description" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:image:alt" content="" />
	<meta name="twitter:card" content="summary_large_image" />


	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') }}" />
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
	<!--Plugin CSS file with desired skin-->
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />

	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
		rel="stylesheet">

	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <style>
		.navbar .nav-link,
		.navbar-brand {
			color: #ffffff !important;
			transition: color 0.3s;
		}

		.navbar .nav-link:hover,
		.navbar-brand:hover {
			color: #ffc107 !important;
		}
	</style> --}}
	@yield('style')
</head>

<body data-instant-intensity="mousedown">

	{{-- <div class="bg-light top-header">
		<div class="container">
			<div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
				<div class="col-lg-4 logo">
					<a href="{{route('front.home')}}" class="text-decoration-none">
						<span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Affili<span
								style="color: #FFD700">Hub</span></span>
					</a>
				</div>
				<div class="col-lg-6 col-6 text-left gap-4 d-flex justify-content-end align-items-center">
					<form action="{{route('front.shop')}}" method="get">
						<div class="input-group">
							<input value="{{Request::get('search')}}" type="text" placeholder="Search For Products"
								class="form-control" name="search" id="search">
							<button type="submit" class="input-group-text">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</form>
					@if (Auth::check())
					<a href="{{route('account.profile')}}" class="nav-link text-dark">{{Auth::user()->name}}</a>
					@else
					<a href="{{route('account.login')}}"
						class="nav-link text-dark btn btn-sm text-white btn-dark">Login</a>
					@endif
				</div>
			</div>
		</div>
	</div> --}}
	{{-- <header class="bg-dark">
		<div class="container">
			<nav class="navbar navbar-expand-xl" id="navbar">
				<a href="index.php" class="text-decoration-none mobile-logo">
					<span class="h2 text-uppercase text-primary bg-dark">Online</span>
					<span class="h2 text-uppercase text-white px-2">SHOP</span>
				</a>
				<button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
					data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					aria-expanded="false" aria-label="Toggle navigation">
					<!-- <span class="navbar-toggler-icon icon-menu"></span> -->
					<i class="navbar-toggler-icon fas fa-bars"></i>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<!-- <li class="nav-item">
          				<a class="nav-link active" aria-current="page" href="index.php" title="Products">Home</a>
        			</li> -->
						@if (getCategories()->isNotEmpty())
						@foreach (getCategories() as $category)
						<li class="nav-item dropdown">
							<button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
								aria-expanded="false">
								{{$category->name}}
							</button>
							@if ($category->sub_category->isNotEmpty())
							<ul class="dropdown-menu dropdown-menu-dark">
								@foreach ($category->sub_category as $subcategory)
								<li><a class="dropdown-item nav-link"
										href="{{route('front.shop',[$category->slug,$subcategory->slug])}}">{{$subcategory->name}}</a>
								</li>
								@endforeach
							</ul>
							@endif
						</li>
						@endforeach
						@endif
					</ul>
				</div>
				<div class="right-nav py-0">
					<a href="{{ route('front.cart') }}" class="ml-3 d-flex align-items-center pt-2">
						<i class="fas fa-shopping-cart text-primary"></i> --}}
						{{-- <span class="badge " style="    margin-left: 0.20rem !important;
    background-color: red;
    border-radius: 50%;
    margin-bottom: 11px;
	padding:1px 2px!imortant;
">{{Cart::content()->count() }}</span> --}}
						{{-- </a>
				</div>
			</nav>
		</div>
	</header> --}}
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<!-- Logo -->
			<a class="navbar-brand fw-bold fs-4" href="{{ route('front.home') }}">Affili<span
					style="color: #FFD700">Hub</span></a>

			<!-- Toggler Button for Mobile View -->
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<!-- Navbar Links -->
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
					<li class="nav-item">
						<a class="nav-link {{ request()->routeIs('front.home') ? 'active' : '' }}"
							href="{{ route('front.home') }}">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{ request()->routeIs('front.shop') ? 'active' : '' }}"
							href="{{ route('front.shop') }}">Shop</a>
					</li>
					<li class="nav-item d-flex">
						@if (staticPages()->isNotEmpty())
							@foreach (staticPages() as $page)
								<a class="nav-link {{ request()->routeIs('front.page', $page->name) ? 'active' : '' }}"
									href="{{ route('front.page', $page->name) }}"
									title="{{ $page->name }}">{{ $page->name }}</a>
							@endforeach
						@endif
					</li>
				</ul>

				<!-- Search Bar -->
				{{-- <form class="d-flex me-3" action="{{ route('front.shop') }}" method="get">
					<input value="{{ request()->get('search') }}" type="text" placeholder="Search For Products"
						class="form-control" name="search" id="search">
					<button type="submit" class="input-group-text ms-1">
						<i class="fa fa-search"></i>
					</button>
				</form> --}}
				<form class="d-flex me-3" action="{{ route('front.shop') }}" method="get"
					onsubmit="return validateSearch()">
					<input value="{{ request()->get('search') }}" type="text" placeholder="Search For Products"
						class="form-control" name="search" id="search">
					<button type="submit" class="input-group-text ms-1">
						<i class="fa fa-search"></i>
					</button>
				</form>

				<!-- Icons -->
				<div class="d-flex align-items-center">
					{{-- <a href="{{ route('front.cart') }}" class="me-3">
						<i class="fas fa-shopping-cart text-primary"></i>
					</a> --}}
					<a href="{{ route('front.cart') }}" class="me-4 position-relative">
						<i class="fas fa-shopping-cart text-primary fs-4"></i>
						@php
							use Gloudemans\Shoppingcart\Facades\Cart;
						@endphp
						@if(Cart::content()->count() > 0)
							<span
								class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger px-2">
								{{ Cart::content()->count() }}
							</span>
						@endif
					</a>
					@if (Auth::check())
						<a href="{{ route('account.profile') }}" class="nav-link text-white">{{ Auth::user()->name }}</a>
					@else
						<a href="{{ route('account.login') }}"
							class="nav-link text-dark btn btn-sm text-white btn-dark">Login</a>
					@endif
				</div>
			</div>
		</div>
	</nav>


	<main>
		@yield('content')
	</main>
	<footer class="bg-dark mt-5">
		<div class="container pb-5 pt-3">
			<div class="row">
				<div class="col-md-4">
					<div class="footer-card">
						<h3>Get In Touch</h3>
						<p>Feel free to reach out to us anytime! <br>
							G-6 Street 56, Islamabad, Pakistan <br>
							affilihub@example.com <br>
							+92 300 1234567</p>
					</div>
				</div>

				<div class="col-md-4">
					<div class="footer-card">
						<h3>Important Links</h3>
						<ul>
							@if (staticPages()->isNotEmpty())
								@foreach (staticPages() as $page)

									<li><a href="{{route('front.page', $page->name)}}"
											title="{{$page->name}}">{{$page->name}}</a></li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>

				<div class="col-md-4">
					<div class="footer-card">
						<h3>My Account</h3>
						<ul>
							<li><a href="{{route('account.login')}}" title="Sell">Login</a></li>
							<li><a href="{{route('account.register')}}" title="Advertise">Register</a></li>
							{{-- <li><a href="{{route('orders.detail')}}" title="Contact Us">My Orders</a></li> --}}
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="copyright-area">
			<div class="container">
				<div class="row">
					<div class="col-12 mt-3">
						<div class="copy-right text-center">
							<p>© Copyright 2024 Amazing Shop. All Rights Reserved</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!--wishlist Modal -->
	<div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Success</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<script src="{{asset('front-assets/js/jquery-3.6.0.min.js')}}"></script>
	<script src="{{asset('front-assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
	<script src="{{asset('front-assets/js/instantpages.5.1.0.min.js')}}"></script>
	<script src="{{asset('front-assets/js/lazyload.17.6.0.min.js')}}"></script>
	<script src="{{asset('front-assets/js/slick.min.js')}}"></script>
	<!--jQuery-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!--Plugin JavaScript file-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

	<script src="{{asset('front-assets/js/custom.js')}}"></script>

	<script type="text/javascript">



		function validateSearch() {
			let searchInput = document.getElementById('search').value.trim();
			if (searchInput === "") {
				alert("Please enter a keyword to search.");
				return false; // Prevent form submission
			}
			return true; // Allow form submission
		}


		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});


		window.onscroll = function () { myFunction() };

		var navbar = document.getElementById("navbar");
		var sticky = navbar.offsetTop;

		function myFunction() {
			if (window.pageYOffset >= sticky) {
				navbar.classList.add("sticky")
			} else {
				navbar.classList.remove("sticky");
			}
		}
		// add to cart
		function addToCart(id) {
			$.ajax({
				url: '{{ route("front.addToCart") }}',
				type: 'post',
				data: { id, id },
				dataType: 'json',
				success: function (response) {
					if (response.status == true) {
						window.location.href = "{{ route('front.cart') }}"
					} else {
						alert(response.message)

					}
				}
			})
		}

		function addToWishList(id) {
			$.ajax({
				url: '{{ route("front.addToWishlist") }}',
				type: 'post',
				data: { id: id },  // Correcting the syntax here to pass the id correctly
				dataType: 'json',
				success: function (response) {
					if (response.status == true) {
						// window.location.href = "{{ route('front.cart') }}";
						$("#wishlistModal .modal-body").html(response.message);
						$("#wishlistModal").modal('show');
					} else {
						window.location.href = "{{ route('account.login') }}";
					}
				}
			});
		}

	</script>
	@yield('customJs')
</body>

</html>
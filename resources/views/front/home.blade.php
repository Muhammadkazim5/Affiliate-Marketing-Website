@extends('front.layout.app')
@section('style')
<style>
    .section-2 {
        background-color: #f8f9fa;
    }

    .feature-card {
        background: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #ddd;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .feature-card .icon {
        color: #007bff;
    }

    .feature-card h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .feature-card p {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .category-card {
        border: none;
        transition: transform 0.3s;
    }

    .category-card:hover {
        transform: scale(1.05);
    }

    .category-card img {
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
    }

    .category-card-title {
        text-align: center;
        margin-top: 10px;
        font-size: 1.1rem;
        font-weight: 600;
    }
</style>
@endsection
@section('content')

{{-- carousal --}}
<section class="section-1">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
        data-bs-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/banner8.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/banner8.jpg')}}" />
                    <img src="images/carousel-2.jpg" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Clothes</h1>
                        <p class="mx-md-5 px-5">Discover the latest in fashion with unbeatable discounts on your
                            favorite clothing items.</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item ">
                <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/banner6.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/banner6.jpg')}}" />
                    <img src="images/carousel-1.jpg" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Kids Fashion</h1>
                        <p class="mx-md-5 px-5">Explore the latest trends in kids' clothing with stylish and comfortable
                            options, all at amazing discounts!</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">

                <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/banner9.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/banner9.jpg')}}" />
                    <img src="images/carousel-2.jpg" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Men's Fashion</h1>
                        <p class="mx-md-5 px-5">Upgrade your wardrobe with the latest styles in men's fashion, offering
                            both comfort and trendsetting designs at unbeatable prices!</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Shop Now</a>
                    </div>
                </div>
            </div>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

{{-- category section --}}

{{-- <section class="section-3 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Categories</h2>
        </div>
        <div class="row pb-3">
            @if (getCategories()->isNotEmpty())
            @foreach (getCategories() as $category)
            <div class="col-lg-3">
                <div class="cat-card">
                    <div class="left">
                        @if ($category->image!="")
                        <img src="{{ asset('uploads/category/' . $category->image) }}" alt="" class="img-fluid">
                        @else
                        <img src="{{asset(" front-assets/images/cat-1.jpg")}}" alt="" class="img-fluid">
                        @endif

                    </div>
                    <div class="right">
                        <div class="cat-data">
                            <h2>{{$category->name}}</h2> --}}
                            {{-- <p>100 Products</p> --}}
                            {{--
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @endif

        </div>
    </div>
</section> --}}


{{-- <section class="section-3 py-5">
    <div class="container">
        <div class="section-title">
            <h2 class="font-weight-bold">Categories</h2>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @if (getCategories()->isNotEmpty())
                @foreach (getCategories() as $category)
                <div class="swiper-slide">
                    <a href="{{route('front.shop',[$category->slug])}}">
                        <div class="category-card text-center shadow">
                            <div class="category-image mb-3">
                                @if ($category->image != "")
                                <img src="{{ asset('uploads/category/' . $category->image) }}"
                                    alt="{{ $category->name }}" class="img-fluid rounded-circle">
                                @else
                                <img src="{{ asset('front-assets/images/cat-1.jpg') }}" alt="Default Category"
                                    class="img-fluid rounded-circle">
                                @endif
                            </div>
                            <div class="category-info">
                                <h3 class="font-weight-bold text-dark">{{ $category->name }}</h3>
                            </div>
                        </div>
                    </a>
                </div>

                @endforeach
                @else
                <div class="swiper-slide">
                    <p>No categories available.</p>
                </div>
                @endif
            </div>
            <!-- Swiper Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Swiper Navigation Buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

    </div>
</section> --}}

{{-- new category slider --}}
<!-- Indicators -->
{{-- <div class="carousel-indicators">
    @foreach (getCategories() as $key => $category)
    <button type="button" data-bs-target="#categoryCarousel" data-bs-slide-to="{{ $key }}"
        class="{{ $key === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key + 1 }}"></button>
    @endforeach
</div> --}}
<section class="py-5">
    <div class="container mt-5">
        <h3 class="text-center mb-4">Explore Categories</h3>
        <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if (getCategories()->isNotEmpty())
                    @foreach (getCategories()->chunk(4) as $index => $chunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach ($chunk as $category)
                                    <div class="col-6 col-md-3">
                                        <a href="{{ route('front.shop', [$category->slug]) }}">
                                            <div class="card category-card text-center shadow">
                                                <div class="category-image mb-3">
                                                    @if ($category->image != "")
                                                        <img src="{{ asset('uploads/category/' . $category->image) }}"
                                                            alt="{{ $category->name }}" class="card-img-top">
                                                    @else
                                                        <img src="{{ asset('front-assets/images/cat-1.jpg') }}" alt="Default Category"
                                                            class="card-img-top">
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="category-card-title text-dark">{{ $category->name }}</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item">
                        <div class="row">
                            <p class="col-12 text-center">No categories available.</p>
                        </div>
                    </div>
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

{{-- features products --}}
<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Featured Products</h2>
        </div>
        <div class="row pb-3">
            @if ($featuredproducts->isNotEmpty())
                    @foreach ($featuredproducts as $product)
                            @php
                                $productImage = $product->product_images->first();
                            @endphp
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{route('front.product', $product->slug)}}" class="product-img">

                                            @if (!empty($productImage->image))
                                                <img src="{{asset('uploads/products/small/' . $productImage->image)}}" alt=""
                                                    class="card-img-top">
                                            @else
                                                <img src="{{asset('admin-assets/img/default-150x150.png')}}" alt="" class="card-img-top">
                                            @endif
                                        </a>
                                        <a onclick="addToWishList({{ $product->id }})" class="whishlist" href="javascript:void(0)"><i
                                                class="far fa-heart"></i></a>

                                        <div class="product-action">
                                            @if ($product->track_qty == 'Yes')
                                                @if ($product->quantity > 0)
                                                    <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}})">
                                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                                    </a>
                                                @else
                                                    <a class="btn btn-dark">
                                                        Out Of Stock
                                                    </a>

                                                @endif
                                            @else
                                                <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}})">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link text-dark fw-bolder" href="product.php">{{$product->name}}</a>
                                        <div class="price mt-2">
                                            <span class="h6 text-underline truncate">
                                                {{ $product->description }}
                                            </span>
                                            <br>
                                            <span class="h6 text-dark"><strong>Rs.{{$product->price}}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    @endforeach
            @endif
        </div>
    </div>
</section>

{{-- latest product --}}
<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Latest Produsts</h2>
        </div>
        <div class="row pb-3">
            @if ($latestproducts->isNotEmpty())
                    @foreach ($latestproducts as $product)
                            @php
                                $productImage = $product->product_images->first();
                            @endphp
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{route('front.product', $product->slug)}}" class="product-img">
                                            @if (!empty($productImage->image))
                                                <img src="{{asset('uploads/products/small/' . $productImage->image)}}" alt=""
                                                    class="card-img-top">
                                            @else
                                                <img src="{{asset('admin-assets/img/default-150x150.png')}}" alt="" class="card-img-top">
                                            @endif
                                        </a>
                                        <a onclick="addToWishList({{ $product->id }})" class="whishlist" href="javascript:void(0)"><i
                                                class="far fa-heart"></i></a>
                                        <div class="product-action">
                                            @if ($product->track_qty == 'Yes')
                                                @if ($product->quantity > 0)
                                                    <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}})">
                                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                                    </a>
                                                @else
                                                    <a class="btn btn-dark">
                                                        Out Of Stock
                                                    </a>
                                                @endif
                                            @else
                                                <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}})">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link text-dark fw-bolder" href="product.php">{{$product->name}}</a>
                                        <div class="price mt-2">
                                            <span class="h6 text-underline truncate">
                                                {{ $product->description }}
                                            </span>
                                            <br>
                                            <span class="h6 text-dark"><strong>Rs.{{$product->price}}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
            @endif
        </div>
    </div>
</section>

{{-- AliExpress Affiliate Products – Shop Now --}}
<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>AliExpress Affiliate Products – Shop Now</h2>
        </div>
        <div class="row pb-3">
            @if ($affiproducts->isNotEmpty())
                    @foreach ($affiproducts as $product)
                            @php
                                $productImage = $product->product_images->first();
                            @endphp
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{$product->affiliate_link}}" class="product-img">
                                            @if (!empty($productImage->image))
                                                <img src="{{asset('uploads/products/small/' . $productImage->image)}}" alt=""
                                                    class="card-img-top">
                                            @else
                                                <img src="{{asset('admin-assets/img/default-150x150.png')}}" alt="" class="card-img-top">
                                            @endif
                                        </a>

                                        <div class="product-action">
                                            @if ($product->track_qty == 'Yes')
                                                @if ($product->quantity > 0)
                                                    <a class="btn btn-dark" href="{{$product->affiliate_link}}">
                                                        <i class="fa fa-shopping-cart"></i> Shop Now
                                                    </a>
                                                @else
                                                    <a class="btn btn-dark">
                                                        Out Of Stock
                                                    </a>
                                                @endif
                                            @else
                                                <a class="btn btn-dark" href="{{$product->affiliate_link}}">
                                                    <i class="fa fa-shopping-cart"></i> Shop Now
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link text-dark fw-bolder" href="product.php">{{$product->name}}</a>
                                        <div class="price mt-2">
                                            <span class="h6 text-underline truncate">
                                                {{ $product->description }}
                                            </span>
                                            <br>
                                            <span class="h6 text-dark"><strong>Rs.{{$product->price}}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
            @endif
        </div>
    </div>
</section>

{{-- <section class="section-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<section class="section-2 py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card shadow-sm p-4 rounded">
                    <div class="icon mb-3 text-primary">
                        <i class="fa fa-check fa-3x"></i>
                    </div>
                    <h3 class="font-weight-bold">Quality Product</h3>
                    <p class="text-muted">We provide the best quality products for our customers.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card shadow-sm p-4 rounded">
                    <div class="icon mb-3 text-primary">
                        <i class="fa fa-shipping-fast fa-3x"></i>
                    </div>
                    <h3 class="font-weight-bold">Free Shipping</h3>
                    <p class="text-muted">Enjoy free shipping on all your orders.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card shadow-sm p-4 rounded">
                    <div class="icon mb-3 text-primary">
                        <i class="fa fa-exchange-alt fa-3x"></i>
                    </div>
                    <h3 class="font-weight-bold">14-Day Return</h3>
                    <p class="text-muted">Hassle-free returns within 14 days of purchase.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card shadow-sm p-4 rounded">
                    <div class="icon mb-3 text-primary">
                        <i class="fa fa-phone-volume fa-3x"></i>
                    </div>
                    <h3 class="font-weight-bold">24/7 Support</h3>
                    <p class="text-muted">We're here to help you any time, day or night.</p>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
@section('customJs')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            centeredSlides: true, // Center slides
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            slidesPerView: 4,
            spaceBetween: 10,
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
            },
        });
    });


</script>
@endsection
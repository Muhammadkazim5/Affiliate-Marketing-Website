@extends('front.layout.app')
@section('style')
<style>
    .size-btn.selected {
        background-color: #968706;
        color: white;
    }

    .size-btn {
        margin: 5px;
        padding-top: 10px 25px 10px 25px;
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">

        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">{{$product->title}}</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row ">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{Session::get('error')}}
                </div>
            @endif
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">
                        @if ($product->product_images)
                            @foreach ($product->product_images as $key => $productImage)
                                <div class="carousel-item {{($key == 0) ? 'active' : ''}}">
                                    <img src="{{asset('uploads/products/large/' . $productImage->image)}}" alt="Image"
                                        class="w-100 h-100">
                                </div>
                            @endforeach
                        @endif

                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light right">
                    <h1>{{$product->name}}</h1>

                    <div class="d-flex mb-3">
                        <div class="star-rating product mt-2" title="">
                            <div class="back-stars">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>

                                <div class="front-stars" style="width: {{$avgRatingPer}}%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <small
                            class="pt-2 ps-1">({{($product->product_ratings_count > 1) ? $product->product_ratings_count . ' Reviews' : $product->product_ratings_count . ' Review'}}
                            )</small>
                    </div>

                    <h2 class="price ">Rs.{{$product->price}}</h2>

                    <p>{{$product->description}}.</p>

                    {{-- <div class="mb-3">
                        <label id="size-label" for="size" class="form-label">Size : Select Size</label>
                        <div id="size-options">
                            <button type="button" class="btn btn-outline-secondary size-btn"
                                data-size="small">Small</button>
                            <button type="button" class="btn btn-outline-secondary size-btn"
                                data-size="medium">Medium</button>
                            <button type="button" class="btn btn-outline-secondary size-btn"
                                data-size="large">Large</button>
                            <button type="button" class="btn btn-outline-secondary size-btn" data-size="xl">XL</button>
                            <button type="button" class="btn btn-outline-secondary size-btn"
                                data-size="xxl">XXL</button>
                        </div>
                    </div> --}}




                    @if ($product->affiliate_product == 'Yes')
                        <a class="btn btn-dark" href="{{ $product->affiliate_link }}" target="_blank">
                            <i class="fa fa-shopping-cart"></i> Shop Now
                        </a>
                    @else
                        @if ($product->track_qty == 'Yes')
                            @if ($product->quantity > 0)
                                <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            @else
                                <a class="btn btn-dark">
                                    Out Of Stock
                                </a>
                            @endif
                        @else
                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $product->id }})">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="bg-light">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                aria-selected="true">Description</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                                type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping &
                                Returns</button>
                        </li> --}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            <p>
                                {{ $product->description }}
                            </p>
                        </div>
                        {{-- <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis
                                suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis
                                alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet
                                consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus
                                earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint
                                ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit,
                                incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem.
                                Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi.
                            </p>
                        </div> --}}
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="col-md-8">
                                <div class="row">
                                    <form action="" id="ratingForm" name="ratingForm" method="psot">
                                        <h3 class="h4 pb-3">Write a Review</h3>
                                        <div class="form-group col-md-6 mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Name">
                                            <p></p>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="Email">
                                            <p></p>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="rating">Rating</label>
                                            <br>
                                            <div class="rating" style="width: 10rem">
                                                <input id="rating-5" type="radio" name="rating" value="5" /><label
                                                    for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-4" type="radio" name="rating" value="4" /><label
                                                    for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-3" type="radio" name="rating" value="3" /><label
                                                    for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-2" type="radio" name="rating" value="2" /><label
                                                    for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-1" type="radio" name="rating" value="1" /><label
                                                    for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                            </div>
                                            <p class="rating_error text-danger"></p>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">How was your overall experience?</label>
                                            <textarea name="comment" id="comment" class="form-control" cols="30"
                                                rows="10" placeholder="How was your overall experience?"></textarea>
                                            <p></p>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-dark">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="overall-rating mb-3">
                                    <div class="d-flex">
                                        <h1 class="h3 pe-3">{{$avgRating}}</h1>
                                        <div class="star-rating mt-2" title="">
                                            <div class="back-stars">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <div class="front-stars" style="width: {{$avgRatingPer}}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-2 ps-2">
                                            ({{($product->product_ratings_count > 1) ? $product->product_ratings_count . ' Reviews' : $product->product_ratings_count . ' Review'}}
                                            )</div>
                                    </div>

                                </div>
                                @if ($product->product_ratings->isNotEmpty())
                                                            @foreach ($product->product_ratings as $rating) 
                                                                                        @php
                                                                                            $ratingPer = ($rating->rating * 100) / 5;
                                                                                        @endphp
                                                                                        <div class="rating-group mb-4">
                                                                                            <span> <strong>{{$rating->username}} </strong></span>
                                                                                            <div class="star-rating mt-2" title="">
                                                                                                <div class="back-stars">
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                                                                    <div class="front-stars" style="width: {{ $ratingPer }}%;">
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="my-3">
                                                                                                <p>{{$rating->comment}}

                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                            @endforeach
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <section class="pt-5 section-8">
    <div class="container">
        <div class="section-title">
            <h2>Related Products</h2>
        </div>
        <div class="col-md-12">
            <div id="related-products" class="carousel">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="#" class="product-img"><img class="card-img-top"
                                        src="{{asset('front-assets/images/product-1.jpg')}}" alt=""></a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                <div class="product-action">
                                    <a class="btn btn-dark" href="javascript:void(0)">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="product.php">Dummy Product Title</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>$100</strong></span>
                                    <span class="h6 text-underline"><del>$120</del></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="#" class="product-img"><img class="card-img-top"
                                        src="{{asset('front-assets/images/product-1.jpg')}}" alt=""></a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                <div class="product-action">
                                    <a class="btn btn-dark" href="#" onclick="addToCart({{$product->id}})">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="product.php">Dummy Product Title</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>$100</strong></span>
                                    <span class="h6 text-underline"><del>$120</del></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="#" class="product-img"><img class="card-img-top"
                                        src="{{asset('front-assets/images/product-1.jpg')}}" alt=""></a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                <div class="product-action">
                                    <a class="btn btn-dark" href="#">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="product.php">Dummy Product Title</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>$100</strong></span>
                                    <span class="h6 text-underline"><del>$120</del></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="#" class="product-img">
                                    <img class="card-img-top" src="{{asset('front-assets/images/product-1.jpg')}}"
                                        alt=""></a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                <div class="product-action">
                                    <a class="btn btn-dark" href="#">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="product.php">Dummy Product Title</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>$100</strong></span>
                                    <span class="h6 text-underline"><del>$120</del></span>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section> --}}
@endsection
@section('customJs')
<script type="text/javascript">
    $('#ratingForm').submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: '{{ route("front.saveRating", $product->id) }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {
                    $("#name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("#email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("#comment").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $(".rating_error").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    window.location.href = '{{ route("front.product", $product->slug) }}'
                }
                else {
                    var errors = response.errors;
                    if (errors.name) {
                        $("#name").addClass('is-invalid').siblings('p').html(errors.name).addClass('invalid-feedback');
                    } else {
                        $("#name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.email) {
                        $("#email").addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                    } else {
                        $("#email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.comment) {
                        $("#comment").addClass('is-invalid').siblings('p').html(errors.comment).addClass('invalid-feedback');
                    } else {
                        $("#comment").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.rating) {
                        $(".rating_error").html(errors.rating);
                    } else {
                        $(".rating_error").html('');
                    }
                }
            }
        })
    })

    //Add event listener to size buttons
    document.querySelectorAll('.size-btn').forEach(button => {
        button.addEventListener('click', function () {
            // Remove 'selected' class from all buttons
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));

            // Add 'selected' class to the clicked button
            this.classList.add('selected');

            // Get the selected size
            let selectedSize = this.getAttribute('data-size');

            // Update the size label with the selected size
            document.getElementById('size-label').textContent = 'Size: ' + selectedSize.charAt(0).toUpperCase() + selectedSize.slice(1);  // Capitalizes the first letter

            // Optionally store the selected size for later use
            console.log("Selected Size: " + selectedSize);
        });
    });
</script>
@endsection
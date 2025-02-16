@extends('front.layout.app')
@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a class="text-dark" href="{{route('front.shop')}}">Shop</a></li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-3">
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $key => $category)
                                        <div class="accordion-item">
                                            @if ($category->sub_category->isNotEmpty())
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $key }}"
                                                        aria-expanded="false" aria-controls="collapseOne">
                                                        {{$category->name}}
                                                    </button>
                                                </h2>
                                            @else
                                                <a href="{{route('front.shop', $category->slug)}}"
                                                    class="nav-item nav-link {{($categorySelected == $category->id) ? 'text-primary' : ''}}">{{$category->name}}</a>
                                            @endif
                                            @if ($category->sub_category->isNotEmpty())
                                                <div id="collapseOne-{{ $key }}"
                                                    class="accordion-collapse collapse {{($categorySelected == $category->id) ? 'show' : ''}}"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach ($category->sub_category as $subcategory)
                                                                <a href="{{route('front.shop', [$category->slug, $subcategory->slug])}}"
                                                                    class="nav-item nav-link {{($subCategorySelected == $subcategory->id) ? 'text-primary' : ''}}">{{$subcategory->name}}</a>
                                                            @endforeach


                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>

                    {{-- <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Canon
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Sony
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Oppo
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Vivo
                                </label>
                            </div>
                        </div>
                    </div> --}}

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest" {{ ($sort == 'latest') ? 'selected' : '' }}>Latest</option>
                                        <option value="price_desc" {{ ($sort == 'price_desc') ? 'selected' : '' }}>Price
                                            High</option>
                                        <option value="price_asc" {{ ($sort == 'price_asc') ? 'selected' : '' }}>Price Low
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if ($products->isNotEmpty())
                                            @foreach ($products as $product)
                                                                @php
                                                                    $productImage = $product->product_images->first();
                                                                @endphp
                                                                <div class="col-md-4">
                                                                    <div class="card product-card">
                                                                        <div class="product-image position-relative">
                                                                            <a href="{{route('front.product', $product->slug)}}" class="product-img">
                                                                                @if (!empty($productImage->image))
                                                                                    <img src="{{asset('uploads/products/small/' . $productImage->image)}}" alt=""
                                                                                        class="card-img-top">
                                                                                @else
                                                                                    <img src="{{asset('admin-assets/img/default-150x150.png')}}" alt=""
                                                                                        class="card-img-top">
                                                                                @endif
                                                                            </a>
                                                                            {{-- <a class="whishlist" href="222"><i class="far fa-heart"></i></a> --}}
                                                                            @if ($product->affiliate_product != 'Yes')
                                                                                <a onclick="addToWishList({{ $product->id }})" class="whishlist"
                                                                                    href="javascript:void(0)">
                                                                                    <i class="far fa-heart"></i>
                                                                                </a>
                                                                            @endif
                                                                            {{-- <div class="product-action">
                                                                                @if ($product->track_qty== 'Yes')
                                                                                @if ($product->quantity>0)
                                                                                <a class="btn btn-dark" href="javascript:void(0)"
                                                                                    onclick="addToCart({{$product->id}})">
                                                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                                                </a>
                                                                                @else
                                                                                <a class="btn btn-dark">
                                                                                    Out Of Stock
                                                                                </a>

                                                                                @endif
                                                                                @else
                                                                                <a class="btn btn-dark" href="javascript:void(0)"
                                                                                    onclick="addToCart({{$product->id}})">
                                                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                                                </a>
                                                                                @endif
                                                                            </div> --}}
                                                                            <div class="product-action">
                                                                                @if ($product->affiliate_product == 'Yes')
                                                                                    <a class="btn btn-dark" href="{{ $product->affiliate_link }}" target="_blank">
                                                                                        <i class="fa fa-shopping-cart"></i> Shop Now
                                                                                    </a>
                                                                                @else
                                                                                    @if ($product->track_qty == 'Yes')
                                                                                        @if ($product->quantity > 0)
                                                                                            <a class="btn btn-dark" href="javascript:void(0)"
                                                                                                onclick="addToCart({{ $product->id }})">
                                                                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                                                                            </a>
                                                                                        @else
                                                                                            <a class="btn btn-dark">
                                                                                                Out Of Stock
                                                                                            </a>
                                                                                        @endif
                                                                                    @else
                                                                                        <a class="btn btn-dark" href="javascript:void(0)"
                                                                                            onclick="addToCart({{ $product->id }})">
                                                                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                                                                        </a>
                                                                                    @endif
                                                                                @endif
                                                                            </div>

                                                                        </div>
                                                                        <div class="card-body text-center mt-3">
                                                                            <a class="h6 link text-dark fw-bolder" href="product.php">{{$product->name}}</a>
                                                                            <div class="price mt-2">
                                                                                <span class="h6 text-underline truncate ">{{ $product->description }}</span>
                                                                                <br>
                                                                                <span class="h5 text-dark"><strong>Rs.{{$product->price}}</strong></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                            @endforeach
                        @endif



                        <div class="col-md-12 pt-5">
                            {{$products->withQueryString()->links()}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('customJs')
<script>
    $("#sort").change(function () {
        apply_filters(slider.result);
    })
    var rangeSlider = $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 2000,
        from: {{ ($priceMin) }},
        step: 10,
        to: {{ ($priceMax) }},
        skin: "round",
        max_postfix: "+",
        prefix: "Rs.",
        onFinish: function (data) {
            apply_filters(data); // pass the slider data here
        }
    });
    var slider = $(".js-range-slider").data("ionRangeSlider");

    function apply_filters(data) {
        // var brands = [];
        // $(".brand-label").each(function() {
        //     if ($(this).is(":checked") == true) {
        //         brands.push($(this).val());
        //     }
        // })

        // price Range filter
        var url = '{{ url()->current() }}?';
        url += '&price_min=' + data.from + '&price_max=' + data.to; // use data.from and data.to
        // console.log(url); // check if url is correct
        var keyword = $("#search").val();
        if (keyword.length > 0) {
            url += '&search=' + keyword;
        }
        //sorting filter
        url += '&sort=' + $("#sort").val()
        window.location.href = url
    }

</script>
@endsection
@section('style')  
<style>
    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* Show only 3 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection
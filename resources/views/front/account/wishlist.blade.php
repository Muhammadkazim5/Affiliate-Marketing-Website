@extends('front.layout.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('account.profile')}}">My Account</a></li>
                <li class="breadcrumb-item">My Wishlist</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
            </div>
        </div>
    <div class="row">
        <div class="col-md-3">
            @include('front.account.common.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                </div>
                <div class="card-body p-4">
                    @if ($wishlists->isNotEmpty())
                        @foreach ($wishlists as $wishlist)                 
                        <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                            <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{route('front.product',$wishlist->product->slug)}}" style="width: 10rem;">
                                {{-- <img src="images/product-1.jpg" alt="Product"> --}}
                                @php
                                   $productImage= getProductImage($wishlist->product_id)
                                @endphp
                                @if (!empty($productImage))
                            <img src="{{asset('uploads/products/small/'.$productImage->image)}}" alt=""   >
                        @else
                            </a>
                    <img src="{{asset('admin-assets/img/default-150x150.png')}}" alt="" >
                        @endif
                                <div class="pt-2">
                                    <h3 class="product-title fs-base mb-2"><a href="{{route('front.product',$wishlist->product->slug)}}">{{$wishlist->product->name}}</a></h3>                                        
                                    <div class="fs-lg text-accent pt-2">Rs.{{$wishlist->product->price}}</div>
                                </div>
                            </div>
                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                <button onclick="removeProduct({{$wishlist->product_id}})" class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                            </div>
                        </div>  
                        @endforeach
                        @else
                        <div>
                            <h3 class="text-center">Your wishlist is Empty</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
    <script>
        function removeProduct(id){
            $.ajax({
        url: '{{ route("account.removeProductFromWishlist") }}',
        type: 'post',
        data: { id: id },  // Correcting the syntax here to pass the id correctly
        dataType: 'json',
        success: function(response){
            if(response.status == true){
                window.location.href = "{{ route('account.wishlist') }}";
            }
        }
    });
        }
    </script>
@endsection
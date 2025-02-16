@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('products.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="" name="productForm" id="productForm">
        @csrf

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input type="text" value="{{$product->name}}" name="title" id="title"
                                                    class="form-control" placeholder="Title">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" value="{{$product->slug}}" readonly name="slug"
                                                    id="slug" class="form-control" placeholder="slug">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" value="{{ $product->description }}"
                                            id="description"
                                            class="form-control">{{ old('description', $product->description)}}</textarea>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="product-gallery">
                        @if ($productImage->isNotEmpty())
                            @foreach ($productImage as $image)
                                <div class="col-md-3" id="image-row-{{$image->id}}">
                                    <div class="card">
                                        <input type="hidden" name="image_id[]" value="{{$image->id}}">
                                        <img src="{{asset('uploads/products/small/' . $image->image)}}" class="card-img-top"
                                            alt="">
                                        <div class="card-body">
                                            <a href="javascript:void(0)" onclick="deleteImage({{$image->id}})"
                                                class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Affiliate Details</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="affiliate_link">Affiliate Link</label>
                                        <input type="text" value="{{$product->affiliate_link}}" name="affiliate_link"
                                            id="affiliate_link" class="form-control" placeholder="affiliate link">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Featured Product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option {{($product->is_featured == 'No') ? 'selected' : ''}} value="No">No</option>
                                    <option {{($product->is_featured == 'Yes') ? 'selected' : ''}} value="Yes">Yes
                                    </option>
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" value="{{ $product->sku }}"
                                            class="form-control" placeholder="sku">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" value="{{ $product->barcode }}"
                                            class="form-control" placeholder="Barcode">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" id="track_qty" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty"
                                                name="track_qty" value="Yes" checked>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <input type="number" value="{{ $product->quantity }}" min="0" name="quantity"
                                            id="quantity" class="form-control" placeholder="quantity">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control ">
                                    <option {{($product->status == 1) ? 'selected' : ''}} value="1">Active</option>
                                    <option {{($product->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">select a category</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option {{($product->category_id == $category->id) ? 'selected' : ''}}
                                                value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3">
                                <label for="sub_category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option value="">select a sub category</option>
                                    @if ($subcategory->isNotEmpty())
                                        @foreach ($subcategory as $subcategory)
                                            <option {{($product->sub_category_id == $subcategory->id) ? 'selected' : ''}}
                                                value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Price</h2>
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="text" value="{{$product->price}}" name="price" id="price"
                                    class="form-control" placeholder="Price">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Related Product</h2>
                            <div class="mb-3">
                                <select multiple class="related-product w-100" name="related_products"
                                    id="related_products"></select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Affiliate Product</h2>
                            <div class="mb-3">
                                <select name="affiliate_product" id="affiliate_product" class="form-control"
                                    onchange="document.getElementById('affiliate_link_container').style.display = this.value === 'Yes' ? 'block' : 'none'">
                                    <option value="No" {{ $product->affiliate_product == 'No' ? 'selected' : '' }}>No
                                    </option>
                                    <option value="Yes" {{ $product->affiliate_product == 'Yes' ? 'selected' : '' }}>Yes
                                    </option>
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3 pt-3" id="affiliate_link_container"
                                style="display: {{ $product->affiliate_product == 'Yes' ? 'block' : 'none' }};">
                                <label for="affiliate_link">Affiliate Link</label>
                                <input type="text" name="affiliate_link" id="affiliate_link" class="form-control"
                                    value="{{ $product->affiliate_link ?? '' }}" placeholder="Affiliate link">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('products.index')}}" class="btn btn-outline-dark ml-3">Back</a>
            </div>
        </div>
    </form>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
    // form ajax start
    $("#productForm").submit(function (event) {
        event.preventDefault();
        var formArray = $(this).serializeArray();
        $("button[type='submit']").prop('disabled', true)
        $.ajax({
            url: '{{ route("products.update", $product->id) }}',  // Ensure this is inside a Blade view
            type: 'put',
            data: formArray,
            dataType: 'json',
            success: function (response) {
                $("button[type='submit']").prop('disabled', false)
                if (response['status'] === true) {
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'],select,input[type='number']").removeClass('is-invalid')
                    window.location.href = "{{route('products.index')}}"
                } else {
                    var errors = response['errors'];
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'],select,input[type='number']").removeClass('is-invalid')
                    $.each(errors, function (key, value) {
                        $(`#${key}`)
                            .addClass('is-invalid')
                            .siblings('p.error')
                            .addClass('invalid-feedback')
                            .html(value);
                    });
                }
            },
            error: function (error) {
                console.error("Something went wrong:", error);

            }
        });
    });
    // form ajax end

    //dropzone start
    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        uploadprogress: function (file, progress, bytesSent) {
            // Disable the upload button when progress is ongoing
            $("button[type=submit]").prop("disabled", true); // Replace with your actual button selector
        },
        url: "{{ route('product-images.update') }}",
        maxFiles: 10,
        paramName: 'image',
        params: { 'product_id': '{{$product->id}}' },
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, response) {
            console.log(response);  // Check the structure of the response

            // Check if response contains Image_id and ImagePath
            if (response && response.Image_id) {
                var image_id = response.Image_id; // Get the Image ID
                var imagePath = response.ImagePath; // Get the Image Path

                // Generate HTML for each image
                var html = `<div class="col-md-3" id="image-row-${image_id}">
                        <div class="card">
                            <input type="hidden" name="image_id[]" value="${image_id}">
                            <img src="${imagePath}" class="card-img-top" alt="">
                            <div class="card-body">
                                <a href="javascript:void(0)" onclick="deleteImage(${image_id})" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>`;

                // Append the HTML to the gallery
                $("#product-gallery").append(html);
                $("button[type=submit]").prop("disabled", false);
            } else {
                console.log("Error: Image_id or ImagePath not found in response.");
            }
        }
    });
    function deleteImage(id) {
        // Confirm deletion
        if (confirm("Are you sure you want to delete this image?")) {
            // Make AJAX request to delete the image
            $.ajax({
                url: '{{ route("product-images.destroy") }}', // Ensure this route matches your Laravel route definition
                type: 'DELETE', // Use the correct HTTP method
                data: {
                    id: id, // Pass the image ID
                },
                success: function (response) {
                    if (response.status === true) {
                        // Remove the image row if deletion is successful
                        $('#image-row-' + id).remove();
                        alert(response.message);
                    } else {
                        // Alert the user if deletion fails
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Log any error for debugging
                    alert("An error occurred while deleting the image.");
                }
            });
        }
    }


    //dropzone end


    $('.related-product').select2({
        ajax: {
            url: '{{ route("products.getProducts") }}',
            dataType: 'json',
            tags: true,
            multiple: true,
            minimumInputLength: 3,
            processResults: function (data) {
                return {
                    results: data.tags
                };
            }
        }
    });




    //
    $(document).ready(function () {
        $('#title').on('input', function () {
            var name = $(this).val();
            // $("button[type=submit]").props('disabled',true)
            if (name) {
                $.ajax({
                    url: "{{ route('getslug') }}",
                    type: 'GET',
                    data: { name: name },
                    success: function (response) {
                        // $("button[type=submit]").props('disabled',false)
                        $('#slug').val(response);
                    },
                    error: function () {
                        console.error("An error occurred while generating the slug.");
                    }
                });
            } else {
                $('#slug').val('');
            }
        });
    });

    // ...
    $("#category_id").change(function () {
        var category_id = $(this).val();
        $.ajax({
            url: '{{route("product-subcategories.index")}}',
            type: 'get',
            data: { category_id: category_id },
            dataType: 'json',
            success: function (res) {
                // console.log(res)
                $('#sub_category').find("option").not(":first").remove();
                $.each(res["subcategories"], function (key, item) {
                    $('#sub_category').append(`<option value='${item.id}'>${item.name}</option>`)
                });
            }, error: function () {
                console.log("Something went wrong!")
            }
        })
    })
</script>
@endsection
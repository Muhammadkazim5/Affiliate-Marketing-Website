@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Product</h1>
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
    <form action="{{route('products.store')}}" method="POST" name="productForm" id="productForm">
        @csrf

        <div class="container-fluid">
            <div class="row">
                {{-- @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif --}}
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" id="title" class="form-control "
                                                    placeholder="Title">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" readonly name="slug" id="slug" class="form-control "
                                                    placeholder="slug">
                                                {{-- @error('slug')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror --}}
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control"
                                            placeholder="Description" class="form-control"></textarea>
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

                    </div>

                    {{-- <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Affiliate Details</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="sku">Affiliate Link</label>
                                        <input type="text" name="affiliate_link" id="affiliate_link"
                                            class="form-control " placeholder="affiliate link">
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
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
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
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control"
                                            placeholder="Barcode">
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
                                        <input type="number" min="0" name="quantity" id="quantity" class="form-control"
                                            placeholder="quantity">
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
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
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
                                <select name="category_id" id="category_id" class="form-control ">
                                    <option value="">select a category</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3">
                                <label for="sub_category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option value="">select a sub category</option>
                                    @if ($subcategories->isNotEmpty())
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
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
                                <input type="text" name="price" id="price" class="form-control " placeholder="Price">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card mb-3" id="size-field" style="display: none;">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Size</h2>
                            <div class="mb-3">
                                <label for="size">Size</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="S" id="sizeS">
                                    <label class="form-check-label" for="sizeS">Small</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="M" id="sizeM">
                                    <label class="form-check-label" for="sizeM">Medium</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="L" id="sizeL">
                                    <label class="form-check-label" for="sizeL">Large</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="XL"
                                        id="sizeXL">
                                    <label class="form-check-label" for="sizeXL">Extra Large</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="XXL"
                                        id="sizeXXL">
                                    <label class="form-check-label" for="sizeXXL">Double Extra Large</label>
                                </div>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Affiliate Product</h2>
                            <div class="mb-3">
                                <select name="affiliate_product" id="affiliate_product" class="form-control"
                                    onchange="document.getElementById('affiliate_link_container').style.display = this.value === 'Yes' ? 'block' : 'none'">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3 pt-3" id="affiliate_link_container" style="display: none;">
                                <label for="affiliate_link">Affiliate Link</label>
                                <input type="text" name="affiliate_link" id="affiliate_link" class="form-control"
                                    placeholder="Affiliate link">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{route('products.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        console.log(formArray);
        $("button[type='submit']").prop('disabled', true)
        $.ajax({
            url: '{{ route("products.store") }}',  // Ensure this is inside a Blade view
            type: 'post',
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
        url: "{{ route('temp-images.create') }}",
        maxFiles: 10,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, response) {
            console.log(response); // Check the response structure
            if (response && response.Image_id) {
                var image_id = response.Image_id;
                var imagePath = response.ImagePath;

                var html = `
            <div class="col-md-3" id="image-row-${image_id}">
                <div class="card">
                    <input type="hidden" name="image_id[]" value="${image_id}">
                    <img src="${imagePath}" class="card-img-top" alt="">
                    <div class="card-body">
                        <a href="javascript:void(0)" onclick="deleteImage(${image_id})" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>`;
                $("#product-gallery").append(html);
                $("button[type=submit]").prop("disabled", false);
            } else {
                console.log("Error: Invalid response");
            }
        },
        complete: function (file) {
            this.removeFile(file);
        }
    });

    function deleteImage(id) {
        console.log("Attempting to delete image with id:", id);
        const element = $("#image-row-" + id);
        if (element.length) {
            element.remove();
            console.log("Image removed successfully.");
        } else {
            console.log("Error: Element not found for id:", id);
        }
    }


    //slug
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


    // size js
    //     $(document).ready(function() {
    //     $("#category_id").change(function() {
    //         var category_id = $(this).val();
    //         var fashionCategoryId = 15; // Replace with the actual ID for the Fashion category

    //         // Show/hide the size field based on the selected category
    //         if (category_id == fashionCategoryId) {
    //             $("#size-field").show();
    //         } else {
    //             $("#size-field").hide();
    //         }

    //         Fetch subcategories
    //         $.ajax({
    //             url: '{{ route("product-subcategories.index") }}',
    //             type: 'get',
    //             data: { category_id: category_id },
    //             dataType: 'json',
    //             success: function(res) {
    //                 $('#sub_category').find("option").not(":first").remove();
    //                 $.each(res["subcategories"], function(key, item) {
    //                     $('#sub_category').append(`<option value='${item.id}'>${item.name}</option>`);
    //                 });
    //             },
    //             error: function() {
    //                 console.log("Something went wrong!");
    //             }
    //         });
    //     });
    // });




</script>
@endsection
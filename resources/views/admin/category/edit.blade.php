@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('categories.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{route('categories.update', $category->id)}}" enctype="multipart/form-data" method="post"
            id="categoryForm" name="categoryForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @method('PUT')
                        @csrf
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" value="{{$category->name}}" name="name" id="name" class="form-control  @error('name')
                                    is-invalid
                                @enderror" placeholder="Name">
                                @error('name')

                                    <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" value="{{$category->slug}}" readonly name="slug" id="slug" class="form-control  @error('slug')
                                    is-invalid
                                @enderror" placeholder="Slug">
                                @error('name')

                                    <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control">
                                @if($category->image)
                                    <img src="{{ asset('uploads/category/' . $category->image) }}" alt="Category Image"
                                        width="100" class="pt-2">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{($category->status == 1) ? 'selected' : ''}} value="1">Active</option>
                                    <option {{($category->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                </select>

                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="showHome">Show on Home</label>
                                <select name="showHome" id="showHome" class="form-control">
                                    <option {{($category->showHome=='Yes')?'selected':''}} value="Yes">Yes</option>
                                    <option {{($category->showHome=='No')?'selected':''}} value="No">No</option>
                                </select>

                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="pb-5 pt-3 pl-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
        </form>
    </div>

    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

<!-- /.content -->
@endsection
@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#name').on('input', function () {
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
</script>
@endsection
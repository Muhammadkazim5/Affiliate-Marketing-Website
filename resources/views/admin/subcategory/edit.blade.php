@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sub-Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('subcategories.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{route('subcategories.update', $subcategory->id)}}" method="post" id="categoryForm"
            name="categoryForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @method('PUT')
                        @csrf
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Category</label>
                                <select name="category_id" id="category" class="form-control @error('category_id')
                                    is-invalid
                                @enderror">
                                    <option value="">select a category</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option {{($subcategory->category_id == $category->id) ? 'selected' : ''}}
                                                value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category_id')
                                    <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" value="{{$subcategory->name}}" name="name" id="name" class="form-control  @error('name')
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
                                <input type="text" value="{{$subcategory->slug}}" readonly name="slug" id="slug" class="form-control  @error('slug')
                                    is-invalid
                                @enderror" placeholder="Slug">
                                @error('name')

                                    <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{($subcategory->status == 1) ? 'selected' : ''}} value="1">Active</option>
                                    <option {{($subcategory->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                </select>

                            </div>
                            {{-- <div class="mb-3">
                                <label for="showHome">Show on Home</label>
                                <select name="showHome" id="showHome" class="form-control">
                                    <option {{($subcategory->showHome == 'Yes') ? 'selected' : ''}} value="Yes">Yes
                                    </option>
                                    <option {{($subcategory->showHome == 'No') ? 'selected' : ''}} value="No">No
                                    </option>
                                </select>

                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3 pl-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('subcategories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
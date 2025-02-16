@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Page</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('pages.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('pages.store')}}" method="post" id="pageForm" name="pageForm" >
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                                @csrf
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control  @error('name')
								is-invalid
							@enderror" placeholder="Name">	
                                    @error('name')
								
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="content">Content</label>
                                    
                                    <textarea cols="30" rows="10"  name="content" id="content" class="summernote form-control  @error('content')
								is-invalid
							@enderror" >	</textarea>
                                    @error('content')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                           
                    </div>	
                    <div class="pb-5 pt-3 pl-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{route('pages.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>						
                </form>
                </div>
          
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

<!-- /.content -->
@endsection
@section('customcss')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">

@endsection
@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

 <script>
    $(function(){
        $('.summernote').summernote({
            height:'300px'
        })
    })
 </script>
@endsection


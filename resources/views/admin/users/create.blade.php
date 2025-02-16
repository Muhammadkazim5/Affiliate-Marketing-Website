@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create User</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('users.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('users.store')}}" method="post" id="userForm" name="userForm" >
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                                @csrf
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control  @error('email')
								is-invalid
							@enderror" placeholder="Email">	
                                    @error('email')
								
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control  @error('phone')
								is-invalid
							@enderror" placeholder="Phone">	
                                    @error('phone')
								
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control  @error('password')
								is-invalid
							@enderror" placeholder="password">	
                                    @error('password')
								
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
    
                                </div>
                            </div>
                    </div>	
                    <div class="pb-5 pt-3 pl-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{route('users.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>						
                </form>
                </div>
          
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

<!-- /.content -->
@endsection


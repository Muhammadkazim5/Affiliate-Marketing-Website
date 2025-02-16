@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        {{-- @if (Session::has('error'))
    
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss='alert' aria-hidden="true"></button>
            <h4><i class="icon fa fa-btn"></i>Error!</h4>
            {{Session::get('error')}}
        </div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss='alert' aria-hidden="true"></button>
            <h4><i class="icon fa fa-check"></i>success!</h4>
            {{Session::get('success')}}
        </div>
        @endif 					 --}}
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="changePassword" name="changePassword" >
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                                @csrf
                            <div class="col-md-12">
                                <div class="mb-3">               
                                    <label for="name">Old Password</label>
                                    <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                               <p></p>
                                </div>
                            </div>   
                            <div class="col-md-12">
                                <div class="mb-3">               
                                    <label for="name">New Password</label>
                                    <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">               
                                    <label for="name">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Old Password" class="form-control">
                               <p></p>
                                </div>
                            </div>  
                    </div>	
                    <div class="pb-5 pt-3 pl-3">
                        <button type="submit" class="btn btn-primary">Update</button>
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
    <script>
        $("#changePassword").submit(function(event){
event.preventDefault();
$.ajax({
    url:'{{ route("admin.changePassword") }}',
    type:'POST',
    data:$(this).serializeArray(),
    dataType:'json',
    success:function(response){
if(response.status == true){
    // $("#old_password").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
    // $("#new_password").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
    // $("#confirm_password").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');

    window.location.href='{{route('admin.showChangePassword')}}'
}
else{
    var errors=response.errors;
if(errors.old_password){
    $("#old_password").addClass('is-invalid').siblings('p').html(errors.old_password).addClass('invalid-feedback');
}else{
    $("#old_password").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
}
if(errors.new_password){
    $("#new_password").addClass('is-invalid').siblings('p').html(errors.new_password).addClass('invalid-feedback');
}else{
    $("#new_password").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
}
if(errors.confirm_password){
    $("#confirm_password").addClass('is-invalid').siblings('p').html(errors.confirm_password).addClass('invalid-feedback');
}else{
    $("#confirm_password").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
}
}
    }
})
        })

    </script>
@endsection

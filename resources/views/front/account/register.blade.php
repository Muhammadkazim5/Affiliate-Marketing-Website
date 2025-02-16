@extends('front.layout.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item">Register</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        <div class="login-form">    
            <form action="" method="POST" id="registrationfrom" class="registrationfrom">
                @csrf
                <h4 class="modal-title">Register Now</h4>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                <p></p>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email" id="email" name="email">
               <p></p>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone">
                <p></p>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                <p></p>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                <p></p>
                </div>
                <div class="form-group small">
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div> 
                <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
            </form>			
            <div class="text-center small">Already have an account? <a href="{{route('account.login')}}">Login Now</a></div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
    <script type="text/javascript">
$("#registrationfrom").submit(function(e){
e.preventDefault();
$("button[type='submit']").prop('disabled',true);
$.ajax({
           url:'{{route('account.processRegister')}}',
           type:'post',
           data:$(this).serializeArray(),
           dataType:'json',
          success:function(response){
            $("button[type='submit']").prop('disabled',false);
            if (response.status == false) {
    var errors = response.errors;  // Access errors from response

    // Check and display errors for name
    if (errors.name) {
        $('#name').siblings("p").addClass('invalid-feedback').html(errors.name[0]);
        $('#name').addClass('is-invalid');
    } else {
        $('#name').siblings("p").removeClass('invalid-feedback').html('');
        $('#name').removeClass('is-invalid');
    }

    // Check and display errors for email
    if (errors.email) {
        $('#email').siblings("p").addClass('invalid-feedback').html(errors.email[0]);
        $('#email').addClass('is-invalid');
    } else {
        $('#email').siblings("p").removeClass('invalid-feedback').html('');
        $('#email').removeClass('is-invalid');
    }

    // Check and display errors for password
    if (errors.password) {
        $('#password').siblings("p").addClass('invalid-feedback').html(errors.password[0]);
        $('#password').addClass('is-invalid');
    } else {
        $('#password').siblings("p").removeClass('invalid-feedback').html('');
        $('#password').removeClass('is-invalid');
    }
} else {
    // Remove all error classes if status is true
    $('#name').siblings("p").removeClass('invalid-feedback').html('');
    $('#name').removeClass('is-invalid');
    $('#email').siblings("p").removeClass('invalid-feedback').html('');
    $('#email').removeClass('is-invalid');
    $('#password').siblings("p").removeClass('invalid-feedback').html('');
    $('#password').removeClass('is-invalid');
    window.location.href='{{route("account.login")}}';
}
         
          },
          error:function(JQXHR,exception){
             console.log("Something went wrong")
          }
       
    })
})

    </script>
@endsection
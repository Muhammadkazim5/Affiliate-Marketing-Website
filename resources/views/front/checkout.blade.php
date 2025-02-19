@extends('front.layout.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        <form action="" method="post" id="orderForm" name="orderForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{(!empty($customerAddress))?$customerAddress->first_name:''}}" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                                    <p></p>
                                    </div>            
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{(!empty($customerAddress))?$customerAddress->last_name:''}}"  name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                                    <p></p>
                                    </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{(!empty($customerAddress))?$customerAddress->email:''}}"  name="email" id="email" class="form-control" placeholder="Email">
                                   <p></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Select a Country</option>
                                            @if ($countries->isNotEmpty())
                                                @foreach ($countries as $country)
                                                <option {{(!empty($customerAddress) && $customerAddress->country_id==$country->id)?'selected':''}}  value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea  name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{(!empty($customerAddress))?$customerAddress->address:''}} </textarea>
                                   <p></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="houseNumber" id="houseNumber" class="form-control" placeholder="House no." value="{{(!empty($customerAddress))?$customerAddress->house_no:''}}" >
                                    
                                    </div>            
                                </div>
    
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{(!empty($customerAddress))?$customerAddress->city:''}}" >
                                    <p></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="district" id="district" class="form-control" placeholder="District" value="{{(!empty($customerAddress))?$customerAddress->district:''}}" >
                                    <p></p>
                                    </div>            
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{(!empty($customerAddress))?$customerAddress->zip:''}}" >
                                   <p></p>
                                    </div>            
                                </div>
    
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." value="{{(!empty($customerAddress))?$customerAddress->mobile:''}}" >
                                    
                                    <p></p></div>            
                                </div>
                                
    
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                   
                                    </div>            
                                </div>
    
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>                    
                    <div class="card cart-summery">
                        <div class="card-body">
                         @foreach (Cart::content() as $item)
                             
                         <div class="d-flex justify-content-between pb-2">
                             <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                             <div class="h6">Rs.{{$item->price*$item->qty}}</div>
                         </div>
                         @endforeach
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>Rs.{{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong>Rs.0</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong>Rs.{{Cart::subtotal()}}</strong></div>
                            </div>                            
                        </div>
                    </div>   
                    
                    <div class="card payment-form ">  
                        <h3 class="card-title h5 mb-3">Payment Method</h3> 
                        <div class="">
                        <input type="radio" checked name="payment_method" id="payment_method_1" value="cod">
                        <label for="payment_method_1" class="form-check-label">Cash On Delivery</label>
                        </div>                     
                        <div class="">
                        <input type="radio" name="payment_method" id="payment_method_2" value="cod">
                        <label for="payment_method_2" class="form-check-label">Online Payment</label>
                        </div>                     
                        
                        <div class="card-body p-0 d-none mt-3" id="card-method-form">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div>
                           
                        </div>  
                        <div class="pt-4">
                            <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>                      
                    </div>
    
        
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
       $('#payment_method_1').click(function(){
if($(this).is(":checked")==true){
    $("#card-method-form").addClass('d-none');
}
});
    $('#payment_method_2').click(function(){
if($(this).is(":checked")==true){
    $("#card-method-form").removeClass('d-none');
}
});

//validation
$("#orderForm").submit(function(event){
event.preventDefault();
$('button[type="submit"]').prop('disabled',true)
$.ajax({
    url:'{{route('front.processCheckout')}}',
    type:'post',
    data:$(this).serializeArray(),
    dataType:'json',
    success:function(response){

var errors=response.errors;
$('button[type="submit"]').prop('disabled',false)
if(response.status==false)
{
    if(errors.first_name){
$("#first_name").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.first_name);
}else{
    $("#first_name").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
 
}
if(errors.last_name){
$("#last_name").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.last_name);
}else{
    $("#last_name").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
 
}
if(errors.email){
$("#email").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.email);
}else{
    $("#email").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
 
}
if(errors.mobile){
$("#mobile").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.mobile);
}else{
    $("#mobile").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
 
}
if(errors.address){
$("#address").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.address);
}else{
    $("#address").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
 
}
if(errors.city){
$("#city").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.city);
}else{
    $("#city").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
 
}
if(errors.country){
$("#country").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.country);
}else{
    $("#country").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
 
}
if(errors.zip){
$("#zip").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.zip);
}else{
    $("#zip").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
 
}
}
else{
window.location.href="{{url('thanks/')}}/"+response.orderId;
}
// .....

    }
})
});
</script>

@endsection
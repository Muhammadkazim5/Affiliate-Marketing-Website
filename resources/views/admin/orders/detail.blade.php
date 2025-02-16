@extends('admin.layouts.app')
@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order: {{$order->id}}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('orders.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
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
                @endif  --}}
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                            <h1 class="h5 mb-3">Shipping Address</h1>
                            <address>
                                <strong>{{ $order->first_name.' '.$order->last_name }}</strong><br>
                               {{$order->address}}<br>
                               {{$order->city}}, {{$order->zip}}, {{$order->countryName}}<br>
                                Phone: {{$order->mobile}}<br>
                                Email: {{$order->email}}
                            </address>
                            <strong>Shipped Date</strong>
                            @if (!empty($order->shipped_date))
                                                    
                            {{ \Carbon\Carbon::parse($order->shipped_date)->format('d,M, Y') }}
                            @else
                                n/a
                            @endif
                            </div>
                            
                            
                            
                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #007612</b><br>
                                <br>
                                <b>Order ID:</b> {{$order->id}}<br>
                                <b>Total:</b> Rs.{{ number_format($order->final_total,2)}}<br>
                                {{-- <b>Status:</b> <span class="text-success">Delivered</span> --}}
                                @if ($order->status=='pending')  
                                <span class="badge bg-danger">Pending</span>
                                @elseif($order->status=='shipped')
                                <span class="badge bg-info">Shipped</span>
                                @elseif ($order->status=='delivered')
                                <span class="badge bg-success">Delivered</span>
                                @else
                                <span class="badge bg-danger">Cancelled</span>
                                @endif
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-3">								
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="100">Qty</th>                                        
                                    <th width="100">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItem as $item)
                                    
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>Rs.{{number_format($item->price,2)}}</td>                                        
                                    <td>{{$item->qty}}</td>
                                    <td>Rs.{{$item->total}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <td>Rs.{{$order->subtotal}}</td>
                                </tr>
                                
                                <tr>
                                    <th colspan="3" class="text-right">Discount:</th>
                                    <td>Rs.0.00</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Shipping:</th>
                                    <td>Rs.0.00</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Grand Total:</th>
                                    <td>Rs.{{number_format($order->final_total,2)}}</td>
                                </tr>
                             
                            </tbody>
                        </table>								
                    </div>                            
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <form  method="Post" class="changeOrderStatus" id="changeOrderStatus">
                        @csrf
                        <div class="card-body">
                            <h2 class="h4 mb-3">Order Status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{($order->status=='pending')?'selected':''}}>Pending</option>
                                    <option value="shipped" {{($order->status=='shipped')?'selected':''}}>Shipped</option>
                                    <option value="delivered" {{($order->status=='delivered')?'selected':''}}>Delivered</option>
                                    <option value="cancelled" {{($order->status=='cancelled')?'selected':''}}>Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="shipped_date" >Shipped Date</label>
                                <input placeholder="Shipped Date" value="{{$order->shipped_date}}" type="text" name="shipped_date" id="shipped_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" name="sendInvoiceEmail" id="endInvoiceEmail">
                            @csrf
                            <h2 class="h4 mb-3">Send Inovice Email</h2>
                            <div class="mb-3">
                                <select name="userType" id="userType" class="form-control">
                                    <option value="customer">Customer</option>                                                
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#shipped_date').datetimepicker({
            format: 'Y-m-d H:i:s', // Corrected format (uppercase Y for year)
        });
    });

    //form submit
    $('#changeOrderStatus').submit(function(event) {
    event.preventDefault();

    let $submitButton = $("button[type='submit']");
    $submitButton.prop('disabled', true);
    if(confirm("Are you sure you want to change status??")){
        $.ajax({
            url: '{{ route("orders.changeOrderStatus", $order->id) }}',
            type: 'POST',
            data: $(this).serialize(), // Serialize form data
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token here
            },
            success: function(response) {
                if (response.status === true) {
                    window.location.href = '{{ route("orders.detail", $order->id) }}';
                } else {
                    alert('Failed to update order status.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error: Unable to process the request.');
            },
            complete: function() {
                $submitButton.prop('disabled', false);
            }
        });
    }
});



//invoice
    $('#endInvoiceEmail').submit(function(event) {
    event.preventDefault();
   if(confirm("Are you sure you want to send email??")){
       $.ajax({
           url: '{{ route("orders.sendInvoiceEmail", $order->id) }}',
           type: 'POST',
           data: $(this).serialize(), // Serialize form data
           dataType: 'json',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token here
           },
           success: function(response) {
               if (response.status === true) {
                   window.location.href = '{{ route("orders.detail", $order->id) }}';
               } else {
                   alert('Failed to send order email.');
               }
           },
           error: function(xhr, status, error) {
               console.error('Error:', error);
               alert('Error: Unable to process the request.');
           }
       });
   }
});

</script>
@endsection


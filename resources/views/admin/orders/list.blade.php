@extends('admin.layouts.app')
@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders</h1>
            </div>
            <div class="col-sm-6 text-right">
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="get">
            <div class="card-header">
                <div class="card-title">
                    <button type="button" onclick="window.location.href='{{route('orders.index')}}'" class="btn btn-default btn-sm">Reset</button>
                </div>
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" value="{{Request::get('keyword')}}" name="keyword" class="form-control float-right" placeholder="Search">
        
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                              </button>
                            </div>
                          </div>
                    </div>
                </div>
            </form>
            <div class="card-body table-responsive p-0">								
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Orders #</th>											
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date Purchased</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->isNotEmpty())
                            @foreach ($orders as $order)       
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->first_name}} {{$order->last_name}}</td>
                                <td>{{$order->email}}</td>
                                <td>{{$order->mobile}}</td>
                                <td>
                                    {{-- <span class="badge bg-success">Delivered</span> --}}
                                    @if ($order->status=='pending')  
                                    <span class="badge bg-danger">Pending</span>
                                    @elseif($order->status=='shipped')
                                    <span class="badge bg-info">Shipped</span>
                                    @elseif ($order->status=='delivered')
                                    <span class="badge bg-success">Delivered</span>
                                    @else
                                    <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>Rs.{{ number_format($order->final_total,2)}}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d,M, Y') }}</td>																				
                                <td>
                                    <a href="{{route('orders.detail',$order->id)}}">
                                        <svg class="view-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" width="16" height="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5C7.305 4.5 3.272 7.533 1.5 12c1.772 4.467 5.805 7.5 10.5 7.5s8.728-3.033 10.5-7.5c-1.772-4.467-5.805-7.5-10.5-7.5zM12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"></path>
                                          </svg>
                                          
                                    </a>
                                </td>																				
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="colspan-5">
                                    Orders Not Found
                                </td>
                            </tr>
                        @endif
                       
                    </tbody>
                </table>										
            </div>
            <div class="card-footer clearfix">
                {{$orders->links()}}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection
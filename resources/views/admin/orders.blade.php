@extends('admin.sidebar')

@section('content1')
<div class="main-panel">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-9".>
                
           
                <div class="d-flex align-items-center align-self-start">
            <h4 class="mb-1 mb-sm-0">Admin Orders</h4>
                </div>
          </div>
<div class="container">
    @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
    <h1>Orders</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Action</th>
                <th>Print</th>
                <th>Send Mail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name}}</td> <!-- Assuming orders have a user relationship -->
                    <td>${{ number_format($order->total_amount) }}</td> <!-- Adjust according to your total amount field -->
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->payment_method }}</td> <!-- Display payment method -->
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    
                    <td>
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
                                <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </form>
                    </td>
                    <td><a href="{{route('order.download',$order->id)}}"class="btn btn-secondary">Print PDF</td>
                
                <td>
                    <a href="{{route('send.order.email', $order->id)}}"class="btn btn-secondary">send Email</td>
                
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
            </div></div></div>
@endsection

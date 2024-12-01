@extends('layout.app')
@section('title', 'Shopping Cart')
@section('content')

    <div class="container mt-5">
		  @if(session('update'))
            <div class="alert alert-success">
                {{ session('update') }}
            </div>
        @endif

        @if(session('remove'))
            <div class="alert alert-danger">
                {{ session('remove') }}
            </div>
        @endif
        
		@if(session('mess'))
		<div class="alert alert-success">
			{{ session('mess') }}
		</div>
	@endif
        <!-- cart -->
	<div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">
					<div class="cart-table-wrap">
						<table class="cart-table">
							<thead class="cart-table-head">
								<tr class="table-head-row">
									<th class="product-remove"></th>
									
									<th class="product-name">Name</th>
									<th class="product-price">Price</th>
									<th class="product-quantity">Quantity</th>
									<th class="product-total">Total</th>
								</tr>
							</thead>
							<tbody>
                                @foreach ($cartItems as $item)
								<tr class="table-body-row">
									<td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
									<td class="product-name">{{ $item->product->name }}</td>
									<td class="product-price">${{  number_format($item->product->price, 2) }}</td>
									<td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 60px;" required>
                                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                        </form>
                                    </td>
                                    <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
								</tr>
                                @endforeach
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="total-section">
						<table class="total-table">
							<thead class="total-table-head">
								<tr class="table-total-row">
									<th>Total</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody>
								<tr class="total-data">
									<td><strong>Subtotal: </strong></td>
									<td>${{ number_format($total, 2) }}</td>
								</tr>
								
							</tbody>
						</table>
						<div class="cart-buttons">
							<a href="{{route('checkout.form')}}" class="boxed-btn black">Check Out</a>
							<a href="{{route('cash.orders')}}" class="boxed-btn black">Check Out</a>
						</div>
					</div>

					
				</div>
            </div>
			</div>
		</div>
	</div>
	<!-- end cart -->

               
@endsection

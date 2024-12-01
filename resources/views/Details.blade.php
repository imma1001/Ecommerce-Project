@extends('layout.app')
@section('title') Details @endsection 
<!-- Details.blade.php -->

@section('content')
@if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
@foreach ($products as $product)
   <!-- single product -->
<div class="single-product mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="single-product-img">
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}">
                </div>
            </div>
            <div class="col-md-7">
                <div class="single-product-content">
                    <h3>{{ $product->name }}</h3>
                    <p class="single-product-pricing">${{ $product->price }}</p>
                    <p>{{ $product->description }}</p>
                        <div class="single-product-form">
                            <form action="{{ route('cart.add',['id' => $product->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" value="1" min="1">
                                
                            </form>
                        <a href="{{route('cart.index')}}" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                       </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection


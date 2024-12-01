@extends('layout.app')

@section('title') Products @endsection 

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Our Products</p>
                    <h1>Shop</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
<!-- product section -->
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">	
                    <h3><span class="orange-text">Our</span> Products</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">
                    {{ session('success') }}
                    </div>
                @endif
                </div>
        </div>

        
        <div class="row">
           
            @foreach ($products as $product)
            <div class="col-lg-4 col-md-6 text-center">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="{{route('products.details', ['id' => $product->id])}}"><img src="{{ asset('storage/' . $product->photo) }}" alt="Product Photo" width="150"></a>
                    </div>
                    <h3>{{$product->name}}</h3>
                    <p class="product-price">{{$product->price}} </p>
                    
                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add',['id' => $product->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i>Add to Cart</button>
                    </form>
        
                </div>
            </div>@endforeach </div></div>
            
		</div>
	</div>
</div>
	<!-- end products -->
    @endsection
    
     

    

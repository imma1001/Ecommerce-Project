@extends('admin.sidebar')
@section('content1')
<div class="main-panel">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-9".>
                 <!-- Form to Create a New Post -->
                 
                     <h1>Edit Product</h1>
                    
                     <form action="{{ route('prod.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                         @csrf
                         @method('PUT')
                 
                         <div class="form-group">
                             <label for="name">Product Name</label>
                             <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                         </div>
                 
                         <div class="form-group">
                             <label for="description">Description</label>
                             <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                         </div>
                 
                         <div class="form-group">
                             <label for="price">Price</label>
                             <input type="text" name="price" class="form-control" value="{{ $product->price }}" required>
                         </div>
                 
                         <div class="form-group">
                             <label for="quantity">Quantity</label>
                             <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" required>
                         </div>
                         <!-- Current Photo Display -->
                        <div class="form-group">
                            <label>Current Photo:</label><br>
                            @if($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" alt="Product Photo" width="150">
                            @else
                                <p>No photo available</p>
                            @endif
                        </div>

                        <!-- New Photo Upload -->
                        <div class="form-group">
                            <label for="photo">Change Photo:</label>
                            <input type="file" name="photo" id="photo" class="form-control-file">
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control"  required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                         <button type="submit" class="btn btn-primary">Update Product</button>
                         <a href="{{ route('prod.admin') }}" class="btn btn-secondary">Cancel</a>
                     </form>
                     
                 
                        
                 

@endsection
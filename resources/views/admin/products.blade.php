@extends('admin.sidebar')
@section('content1')
<div class="main-panel">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-9".>
                
           
                <div class="d-flex align-items-center align-self-start">
            <h4 class="mb-1 mb-sm-0">Admin Products</h4>
                </div>
          </div>
          
              <h1>Product List</h1>
          
              @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
              @endif
          
              <a href="{{ route('prod.create') }}" class="btn btn-primary">Add Product</a>
          
              <table class="table">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Category</th>
                          <th>Photo</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($products as $product)
                          <tr>
                              <td>{{ $product->name }}</td>
                              <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $product->description }}</td>
                              <td>{{ $product->price }}</td>
                              <td>{{ $product->quantity }}</td>
                              <td>{{ $product->category->name ?? 'N/A' }}</td>

                              <td><img src="{{ asset('storage/' . $product->photo) }}" alt="Product Photo" width="150"></td>
                                <td>
                                  <a href="{{ route('prod.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                                  <form action="{{ route('prod.destroy', $product->id) }}" method="POST" style="display:inline;">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger">Delete</button>
                                  </form>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          @endsection
          


@extends('admin.sidebar')
@section('content1')
<div class="main-panel">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-9".>
                @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
           
                <div class="d-flex align-items-center align-self-start">
            <h4 class="mb-1 mb-sm-0">Admin Categories</h4>
                </div>
          </div>
        <form method= "POST" action="{{url('/store_category')}}">
            @csrf
            
            <input class="form-control" type="text" name="name" placeholder="Enter category" aria-label="default input example">
            <input type="submit" name="submit" class="btn btn-info" value="Add Cat"></form>
                </div></div>
    </div>
</div>
<table class="table">
    
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Category</th>
        <th scope="col">Action</th>
        
      </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
      <tr>
        <th scope="row">{{$category->id}}</th>
        <td>{{$category->name}}</td>
        <td><form action="{{ route('category.destroy', $category->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
            
            
        </form>
        </td>
        
      </tr>
      
    </tbody>
    @endforeach
    @if (session('delete'))
            <div class="alert alert-danger">
                {{ session('delete') }}
            </div>
            @endif
  </table>
@endsection
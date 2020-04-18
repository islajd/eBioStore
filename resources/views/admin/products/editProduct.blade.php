@extends('layouts.master')

@section('title')
    Edit Product
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Edit Product </h4>
                    <form method="POST" action="{{ url('product-update/'.$product->id) }}" enctype="multipart/form-data">
                        <div class="modal-body">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Product Name:</label>
                                <input type="text" name="name" class="form-control" value=" {{ $product->name }}">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Price:</label>
                                <input type="text" name="price" class="form-control" value=" {{ $product->price }}">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Stock:</label>
                                <input type="text" name="stock" class="form-control" value=" {{ $product->stock }}">
                                <select name="measurement_type" class="form-control">
                                    @foreach($measurement_types as $measurement)
                                        @if($measurement->id == $product->measurement_id)
                                            <option value="{{ $measurement->id }}" selected>{{ $measurement->name }}</option>
                                        @else
                                            <option value="{{ $measurement->id }}">{{ $measurement->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Description:</label>
                                <textarea class="form-control" name="description">{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Category:</label>
                                <select name="category" class="form-control">
                                    @foreach($categories as $category)
                                        @if($category->id == $product->category_id)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input"
                                       name="image" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Image</label>
                            </div>
                            <img src="storage/app/public/product_images/{{ $product->image }}" width="100" height="100">
                        </div>
                        <div class="modal-footer">
                            <a href=" {{ url('products') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

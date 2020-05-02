@extends('layouts.master')

@section('title')
    Products
@endsection

@section('content')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="/product/save" enctype="multipart/form-data">
                <div class="modal-body">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Product Name:</label>
                            <input type="text" name="name" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Price:</label>
                            <input type="number" name="price" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Stock:</label>
                            <input type="number" step="0.01" name="stock" class="form-control" id="recipient-name">
                            <select name="measurement_type" class="form-control" style="display: inline-block">
                                @foreach($measurement_types as $measurement_type)
                                    <option value="{{ $measurement_type->id }}">{{ $measurement_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" id="message-text"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Category:</label>
                            <select name="category" class="form-control">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01"
                                   name="image" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Image</label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Products
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"data-target="#exampleModal">Add New Product</button>
                    </h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <style>
                    .w-10 { width: 10% !important}
                </style>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class=" text-primary">
                            <th class="w-10">Name</th>
                            <th class="w-10">Price</th>
                            <th class="w-10">Image</th>
                            <th class="w-10">Description</th>
                            <th class="w-10">Stock</th>
                            <th class="w-10">Date</th>
                            <th class="w-10">Category</th>
                            <th class="w-10">EDIT</th>
                            <th class="w-10">DELETE</th>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->image }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->stock }} {{$product->measurement_name}}</td>
                                    <td>{{ $product->date }}</td>
                                    <td>{{ $product->category_name }}</td>
                                    <td>
                                        <a href="/product/{{ $product->product_id }}/edit" class="btn btn-success">EDIT</a>
                                    </td>
                                    <td>
                                        <form action="/product/{{ $product->product_id }}/delete" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

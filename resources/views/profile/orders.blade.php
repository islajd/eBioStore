@extends('layouts.app')

@section('order_details')

    <div class="cart" style="max-width: 70rem; float: none; margin: 0 auto 10px;">
        <div class="cart-header">
            <h1 style="color: #0b2e13">Details</h1>
        </div>
        <div class="cart-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Product Image</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price Per Unit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order_detail as $od)
                    <tr>
                        <td><img src="{{ asset('/storage/product_images/'.$od->image) }}" width="50px" height="50px"> </td>
                        <td><a href=" {{route("Product",["id" => $od->product_id])}}">{{$od->name}}</a></td>
                        <td>{{$od->description}}</td>
                        <td>{{$od->quantity}} {{$od->measure}}</td>
                        <td>{{$od->price}} $</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="card text-white bg-success mb-3" style="max-width: 40rem;">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <h5 class="card-title">Total Price: {{$total}} $</h5>
                    <h5 class="card-title">Status: {{$order->status}}</h5>
                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.app')

@section('order_details')

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
                <td><img src="{{storage_path('app\public\product_images')}}\{{$od->image}}"> </td>
                <td>{{$od->name}}</td>
                <td>{{$od->description}}</td>
                <td>{{$od->quantity}} {{$od->measure}}</td>
                <td>{{$od->price}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="card text-white bg-success mb-3" style="max-width: 40rem;">
        <div class="card-header">Details</div>
        <div class="card-body">
            <h5 class="card-title">Total Price: {{$total}}</h5>
            <h5 class="card-title">Status: {{$order->status}}</h5>
        </div>
    </div>
@endsection

@extends('layouts.master')

@section('title')
    Order - Details
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Details </h4>
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
                            <th class="w-10">Quantity</th>
                            <th class="w-10">Description</th>
                            <th class="w-10">Image</th>
                            <th class="w-10">Category</th>
                            </thead>
                            <tbody>
                            @foreach($order_details as $detail)
                                <tr>
                                    <td>{{ $detail->name }}</td>
                                    <td>{{ $detail->price }} $</td>
                                    <td>{{ $detail->quantity }} {{ $detail->measurement_name }}</td>
                                    <td>{{ $detail->description }} </td>
                                    <td><img src="{{ asset('/storage/product_images/'.$detail->image) }}" width="50" height="50"></td>
                                    <td>{{ $detail->category_name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            @if($order->status == "SEND")
                                <form action="{{route('changeOrderStatus',['orderId'=>$order->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    <button class="btn btn-success">{{ $order->status }}</button>
                                </form>
                            @else
                                <form action="{{route('changeOrderStatus',['orderId'=>$order->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    <button class="btn btn-warning">{{ $order->status }}</button>
                                </form>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

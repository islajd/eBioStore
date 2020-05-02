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
                                    <td>{{ $detail->price }}</td>
                                    <td>{{ $detail->quantity }} {{ $detail->measurement_name }}</td>
                                    <td>{{ $detail->description }} </td>
                                    <td>{{ $detail->image }}</td>
                                    <td>{{ $detail->category_name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            @if($order->status == "SEND")
                                <form action="/order/{{$order->id}}/changeStatus" method="POST">
                                    {{ csrf_field() }}
                                    <button class="btn btn-success">{{ $order->status }}</button>
                                </form>
                            @else
                                <form action="/order/{{$order->id}}/changeStatus" method="POST">
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

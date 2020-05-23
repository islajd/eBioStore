@extends('layouts.master')

@section('title')
    Orders
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Orders </h4>
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
                        <table class="stripe" id="myTable">
                            <thead class=" text-primary">
                            <th class="w-10">Date</th>
                            <th class="w-10">Address</th>
                            <th class="w-10">Status</th>
                            <th class="w-10">Details</th>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->date }}</td>
                                    <td>{{ $order->address}}</td>
                                    @if($order->status == "SEND")
                                        <td>
                                            <form action="{{route('changeOrderStatus',['orderId'=>$order->id])}}" method="POST">
                                                {{ csrf_field() }}
                                                <button class="btn btn-success">{{ $order->status }}</button>
                                            </form>
                                        </td>
                                    @else
                                        <td>
                                            <form action="{{route('changeOrderStatus',['orderId'=>$order->id])}}" method="POST">
                                                {{ csrf_field() }}
                                                <button class="btn btn-warning">{{ $order->status }}</button>
                                            </form>
                                        </td>
                                    @endif
                                    <td>
                                        <a href="{{route('orderDetails',['orderId'=>$order->id])}}" class="btn btn-secondary">Details</a>
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
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endsection

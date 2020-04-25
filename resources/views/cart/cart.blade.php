@extends('layouts.app')

@section('cart')
    <p class="h1">Cart</p>
    @if (session('status'))
        <div class="alert alert-danger" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Amount</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
        <tr>
            <th scope="row">1</th>
            <td>{{$product->name}}</td>
            <td> <input type="number"  id="price" value="{{$product->price}}" hidden> {{$product->price}} LEK</td>
            <td>
                <form method="POST" action="changeAmount/{{$product->product_id}}">
                    {{ csrf_field() }}
                    <input type="number" value="{{$product->quantity}}" name="amount">
                    <button type="submit" class="btn btn-primary">Change</button>
                </form>
            </td>
            <td id="total">{{$product->price * $product->quantity}}</td>
            <td>
                <form action="deleteProductAtCart/{{ $product->product_id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger">DELETE</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div class="card text-white bg-success mb-3" style="max-width: 40rem;">
        <div class="card-header">Cart Totals</div>
        <div class="card-body">
            <h5 class="card-title">Total: {{$total}}</h5>
        </div>
        <div class="card-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <form method="GET" action="#">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Proceed To Checkout</button>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <form method="POST" action="/emptyCart">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">Empty Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

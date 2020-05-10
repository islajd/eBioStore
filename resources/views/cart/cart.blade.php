@extends('layouts.app')

@section('cart')

    <div class="cart" style="max-width: 70rem; float: none; margin: 0 auto 10px;">
        <div class="cart-header">
            <h1 style="color: #0b2e13">My Cart</h1>
            @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="cart-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Image</th>
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
                    <td><img src="{{ asset('/storage/product_images/'.$product->image) }}" width="50px" height="50px"></td>
                    <td>{{$product->name}}</td>
                    <td> <input type="number"  id="price" value="{{$product->price}}" hidden> {{$product->price}} ALL</td>
                    <td>
                        <form method="POST" action="cart/{{$product->product_id}}/changeAmount">
                            {{ csrf_field() }}
                            <input type="number" value="{{$product->quantity}}" name="amount">
                            <button type="submit" class="btn btn-primary">Change</button>
                        </form>
                    </td>
                    <td id="total">{{$product->price * $product->quantity}}</td>
                    <td>
                        <form action="cart/delete/{{ $product->product_id }}/product" method="POST">
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
        <div class="card-footer">
            <div class="card text-white bg-success mb-3" style="max-width: 40rem;">
                <div class="card-header">Cart Totals</div>
                <div class="card-body">
                    <h5 class="card-title">Total: {{$total}}</h5>
                </div>
                <div class="card-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <form method="GET" action="checkout">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary">Proceed To Checkout</button>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <form method="POST" action="cart/empty">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger">Empty Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.app')

@section('cart')

    <div class="container">
        <div>
            @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                        <tr class="text-center">
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr class="text-center">
                                <td>
                                    <form action="cart/delete/{{ $product->product_id }}/product" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">X</button>
                                    </form>
                                </td>

                                <td><img src="{{ asset('/storage/product_images/'.$product->image) }}" width="100px" height="100px" style="border-radius: 50%"></td>

                                <td>
                                    <h3><a href="/product/{{$product->product_id}}">{{$product->name}}</a> </h3>
                                    <p>{{$product->description}}</p>
                                </td>

                                <td>${{$product->price}}/{{$product->measurement_name}}</td>

                                <td>
                                    <form method="POST" action="cart/{{$product->product_id}}/changeAmount">
                                        {{ csrf_field() }}
                                        <div class="input-group mb-3">
                                            <input type="number" step='0.1' value="{{$product->quantity}}" name="amount" class="quantity form-control input-number" max="{{$product->stock}}" min="1" style="width: 10px">
                                            <button type="submit" class="btn btn-primary">Change</button>
                                        </div>
                                    </form>
                                </td>

                                <td class="total" id="total">${{$product->price * $product->quantity}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-4 mt-5">
                <div class="mb-3">
                    <h3>Cart Totals</h3>
                    <hr>
                    <p class="d-flex total-price">
                        <span> <b>Total</b> ${{$total}}</span>
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <form method="GET" action="checkout">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary py-3 px-4">Proceed To Checkout</button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form method="POST" action="cart/empty">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger py-3 px-4">Empty Cart</button>
                        </form>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <br>

@endsection

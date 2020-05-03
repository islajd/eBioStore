@extends('layouts.app')
@section('product')
    <div class="row">
        @include('home.categories')
        <div class="col-md-10">
            <div class="container" style="margin-top: 10px;">
                <div class="row">
                    <div class="col-md-5 border-right">
                        <img class="d-block w-100" src="{{ asset('/storage/product_images/'.$product->image) }}" alt="Product">
                    </div>
                    <div class="col-md-7 p-5">
                        <form action="/cart/addToCart/{{$product->product_id}}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <h3 style="color: #1c7430;"> {{$product->name}}</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <p style=" color: #FF980F;font-size: 26px;font-weight: bold;padding-top: 20px;"> Price: {{$product->price}} LEK </p>
                            </div>
                            <div class="row">
                                <p> <b>Description: </b> {{$product->description}} </p>
                            </div>
                            <div class="row">
                                <p><b> Availability: </b> {{$product->stock}} </p>
                            </div>
                            <div class="row">
                                <div class="input-group">
                                    <div class="pt-2">
                                        <label><b>Quantity:</b></label>
                                    </div>
                                    <div class="pb-2 pl-4">
                                        <button type="button" onclick="decrease()" >-</button>
                                        <input type="number" value="1" id="quantity" name="quantity" style="-moz-appearance: textfield; border: 1px solid #ccc;font-weight: bold;height: 33px;text-align: center;width: 30px;">
                                        <button type="button" onclick="increase()" >+</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @guest
                                <div class="alert alert-warning" role="alert">
                                    Please Login If You Want To Buy
                                </div>
                            @else
                                <div class="row">
                                    <button type="submit" class="btn btn-success"> Add To Cart </button>
                                </div>
                            @endguest
                        </form>
                        <br>
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
                </div>
            </div>
            <script>
                function increase(){
                    var textBox= document.getElementById("quantity");
                    textBox.value++;
                }
                function decrease(){
                    var textBox = document.getElementById("quantity");
                    if(textBox.value > 1) textBox.value--;
                }
            </script>
        </div>
    </div>
@endsection

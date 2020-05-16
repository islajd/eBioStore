@extends('layouts.app')

@section('home')
    <div class="row mr-auto">
        @include('home.categories')
        <div class="col-md-10">
            @if ($products->count() == 0)
                <div class="row pt-4 justify-content-center">
                    <div class="alert alert-info card pl-4 w-50" role="alert">
                        <div class="card-header">
                            <i class="fa fa-info-circle"></i>
                            <span>Message</span>
                        </div>
                        <div class="card-body">
                            <span>Didn't found any product, visit latter.</span>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('PaymentStatus'))
                <div class="row pt-4 justify-content-center alert alert-success" role="alert">
                    {{ session('PaymentStatus') }}
                </div>
            @elseif(session('error'))
                <div class="row pt-4 justify-content-center alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row pt-4">
                    @foreach($products as $product)
                        <div class="card m-4 bg-transparent " style="width: 20%;">
                            <img src="{{ asset('/storage/product_images/'.$product->image) }}" class="card-img-top" alt="..." width="100" height="150">
                            <div class="card-body mt-2 mr-2 ml-2">
                                <div class="row">
                                    <a href="/product/{{$product->product_id}}" class="anchorjs-link"><h5 class="card-title">{{$product->name}}</h5></a>
                                </div>
                                <div class="row justify-content-between" >
                                    <i>{{$product->sold}} <span>orders</span> </i>
                                    <b style="color: green">${{$product->price}}</b>
                                </div>
                                <div class="row">
                                    <a href="/category/{{$product->category_id}}"> <i class="fa fa-angle-right" style="font-size: 15px;"></i> {{$product->category_name}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
@endsection

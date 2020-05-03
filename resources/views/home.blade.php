@extends('layouts.app')

@section('home')
    <div class="row">
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
            <div class="row pt-4">
                <ul>
                    @foreach($products as $product)
                        <li class="card p-4">
                            <a href="/product/{{$product->product_id}}" class="pl-1">{{$product->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

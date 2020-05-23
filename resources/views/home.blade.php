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
                <div class="ml-auto col-md-8">
                </div>
                <div class="mr-auto">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle filter_icon" data-toggle="dropdown">
                            <i class="fa fa-filter"></i>
                        </a>
                        <div class="dropdown-menu">
                            <form id="nASC" method="GET">
                                @if(request()->get('_token'))
                                    <input type="text" name="_token" value="{{request()->get('_token')}}" hidden>
                                    <input type="text" name="product" value="{{request()->get('product')}}" hidden>
                                @endif
                                <input type="text" name="o" value="name" hidden>
                                <input type="text" name="t" value="ASC" hidden>
                            </form>
                            <form id="nDESC" method="GET">
                                @if(request()->get('_token'))
                                    <input type="text" name="_token" value="{{request()->get('_token')}}" hidden>
                                    <input type="text" name="product" value="{{request()->get('product')}}" hidden>
                                @endif
                                <input type="text" name="o" value="name" hidden>
                                <input type="text" name="t" value="DESC" hidden>
                            </form>
                            <form id="pASC" method="GET">
                                @if(request()->get('_token'))
                                    <input type="text" name="_token" value="{{request()->get('_token')}}" hidden>
                                    <input type="text" name="product" value="{{request()->get('product')}}" hidden>
                                @endif
                                <input type="text" name="o" value="price" hidden>
                                <input type="text" name="t" value="ASC" hidden>
                            </form>
                            <form id="pDESC" method="GET">
                                @if(request()->get('_token'))
                                    <input type="text" name="_token" value="{{request()->get('_token')}}" hidden>
                                    <input type="text" name="product" value="{{request()->get('product')}}" hidden>
                                @endif
                                <input type="text" name="o" value="price" hidden>
                                <input type="text" name="t" value="DESC" hidden>
                            </form>
                            <form id="dASC" method="GET">
                                @if(request()->get('_token'))
                                    <input type="text" name="_token" value="{{request()->get('_token')}}" hidden>
                                    <input type="text" name="product" value="{{request()->get('product')}}" hidden>
                                @endif
                                <input type="text" name="o" value="created_at" hidden>
                                <input type="text" name="t" value="ASC" hidden>
                            </form>
                            <form id="dDESC" method="GET">
                                @if(request()->get('_token'))
                                    <input type="text" name="_token" value="{{request()->get('_token')}}" hidden>
                                    <input type="text" name="product" value="{{request()->get('product')}}" hidden>
                                @endif
                                <input type="text" name="o" value="created_at" hidden>
                                <input type="text" name="t" value="DESC" hidden>
                            </form>
                            <a class="dropdown-item" onclick="document.getElementById('nASC').submit()">Name  -  Ascending</a>
                            <a class="dropdown-item" onclick="document.getElementById('nDESC').submit()">Name  -  Descending</a>
                            <a class="dropdown-item" onclick="document.getElementById('pASC').submit()">Price -  Ascending</a>
                            <a class="dropdown-item" onclick="document.getElementById('pDESC').submit()">Price -  Descending</a>
                            <a class="dropdown-item" onclick="document.getElementById('dASC').submit()">Date  -  Ascending</a>
                            <a class="dropdown-item" onclick="document.getElementById('dDESC').submit()">Date  -  Descending</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($products as $product)
                    <div class="card m-4 bg-transparent" style="width: 20%;">
                        <img src="{{ asset('/storage/product_images/'.$product->image) }}" class="card-img-top" alt="..." width="100" height="150">
                        <div class="card-body mt-2 mr-2 ml-2">
                            <div class="row">
                                <a href="{{route('Product',["id" => $product->product_id])}}" class="anchorjs-link"><h5 class="card-title">{{$product->name}}</h5></a>
                            </div>
                            <div class="row justify-content-between" >
                                @if($product->sold)
                                    <i>{{$product->sold}} <span>orders</span> </i>
                                @else
                                    <i>0 <span>orders</span> </i>
                                @endif

                                <b style="color: green">${{$product->price}}</b>
                            </div>
                            <div class="row">
                                <a href="{{route("Category",["id" => $product->category_id])}}"> <i class="fa fa-angle-right" style="font-size: 15px;"></i> {{$product->category_name}}</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                {{$products->withQueryString()->links()}}
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('home')
    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-list"></i>
                    <span>Categories</span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <li class="list-group-item pl-0">
                                <i class="fa fa-angle-right" style="font-size: 15px;"></i>
                                <a href="/category/{{$category->id}}" class="pl-1">{{$category->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
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
            <ul>
                @foreach($products as $product)
                    <li>
                        {{$product->product_id}}
                    </li>
                @endforeach
            </ul>
        </div>


{{--        <div class="col-md-10">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">Dashboard</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    <ul>--}}
{{--                        @foreach($products as $product)--}}
{{--                            <li>--}}
{{--                                {{$product->product_id}}--}}
{{--                            </li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection

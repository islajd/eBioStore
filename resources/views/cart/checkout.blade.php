@extends('layouts.app')

@section('checkout')

    <div class="container">
        <div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @endif
        </div>
        <form method="POST" action="{{ route('PayPal') }}">
            {{ csrf_field() }}

            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <br>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Your Address *" rows="8" required="required" data-error="Please, leave us address."></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="row mt-5 pt-3">
                        <div class="col-md-12 d-flex mb-5">
                            <div class="p-3 p-md-4">
                                <h3 class="mb-4">Cart Total</h3>
                                <hr>
                                <p class="d-flex">
                                    <span><b>Total</b> ${{$total}}</span>
                                    <input type="hidden" value="{{$total}}" name="total">
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 p-md-4">
                <h3 class="mb-4">Payment Method</h3>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="radio">
                            <label><input type="radio" checked='checked' name="payPalRadio" class="mr-2"> PayPal</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-primary py-3 px-4" value="Place an order">
                        <a href="cart" class="btn btn-secondary py-3 px-4">Back To Cart</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@extends('layouts.app')

@section('checkout')
    <div class="card bg-light mb-3" style="max-width: 40rem; float: none; margin: 0 auto 10px;">
        <div class="card-header">
            Checkout
        </div>
        <div class="card-body">
            <form id="contact-form" method="post" action="createOrderByCart">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <h1>Total Price: {{$total}}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Your Address *" rows="4" required="required" data-error="Please, leave us address."></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-success btn-send" value="Order Now">
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

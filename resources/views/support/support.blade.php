@extends('layouts.app')

@section('support')
    <div class="card bg-light mb-3" style="max-width: 40rem; float: none; margin: 0 auto 10px;">
        <div class="card-header">
            Support
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="card-body">
            <form id="contact-form" method="post" action="sendSupportRequest">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name *</label>
                            <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="First Name is required.">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name *</label>
                            <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Last Name is required.">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number *</label>
                            <input id="phone_number" type="text" name="phone_number" class="form-control" placeholder="Please enter your phone number *" required="required" data-error="Valid phone number is required.">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_message">Message *</label>
                            <textarea id="form_message" name="message" class="form-control" placeholder="Your Message *" rows="4" required="required" data-error="Please, leave us a message."></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-success btn-send" value="Send message">
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

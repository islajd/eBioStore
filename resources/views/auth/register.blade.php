@extends('layouts.app')
@section('register')
    <div class="row justify-content-center modal fade" id="modalForm" role="dialog">
    <div class="col-md-4 modal-dialog" role="document">
        <div class="card modal-content">
            <div class="modal-header">
                <span style="color: green"> {{ __('Register') }}</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-10 offset-md-1 input-group">
                            <input id="first_name" type="text" placeholder="{{"First Name"}}" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-1 input-group">
                            <input id="last_name" type="text" placeholder="{{"Last Name"}}" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-1 input-group">
                            <input id="email" type="email" placeholder="{{"Email"}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-1 input-group">
                            <input id="password" type="password" placeholder="{{"Password"}}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-1 input-group">
                            <input id="password-confirm" type="password" placeholder="{{"Confirm Password"}}" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-1 input-group">
                            <input id="address" type="text" placeholder="{{"Address"}}" class="form-control" name="address" value="{{ old('address') }}" autocomplete="address" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-1 input-group">
                            <input id="phone_number" type="number" placeholder="{{"Phone Number"}}" class="form-control" name="phone_number" value="{{ old('phone_number') }}" autocomplete="phone_number" autofocus>
                        </div>
                    </div>

                    <div class="form-group row mb-0 pb-1">
                        <div class="col-md-10 offset-md-1">
                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

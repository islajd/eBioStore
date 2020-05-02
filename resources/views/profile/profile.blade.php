@extends('layouts.app')

@section('profile')
    <div class="card card-body bg-light">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <ul class="nav nav-tabs">
            <li class="nav-item"><a href="#profileDetails" data-toggle="tab" class="nav-link">Profile</a></li>
            <li class="nav-item"><a href="#password" data-toggle="tab" class="nav-link">Password</a></li>
            <li class="nav-item"><a href="#orders" data-toggle="tab" class="nav-link">My Orders</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane active in" id="profileDetails" role="tabpanel" aria-labelledby="home-tab">
                <form id="tab" method="POST" action="user/edit">
                    {{ csrf_field() }}
                    <br>
                    <label>First Name</label>
                    <input type="text" value="{{$user->first_name}}" name="first_name" class="input-xlarge">
                    <br>
                    <label>Last Name</label>
                    <input type="text" value="{{$user->last_name}}" name="last_name" class="input-xlarge">
                    <br>
                    <label>Email</label>
                    <input type="email" value="{{$user->email}}" name="email" class="input-xlarge">
                    <br>
                    <label>Phone Number</label>
                    <input type="text" value="{{$user->phone_number}}" name="phone_number" class="input-xlarge">
                    <br>
                    <label>Address</label>
                    <br>
                    <textarea value="{{$user->address}}" rows="4" cols="50" name="address" class="input-xlarge">{{$user->address}}</textarea>
                    <br>
                    <div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="password">
                <form id="tab2" action="user/changePassword" method="POST">
                    {{ csrf_field() }}
                    <br>
                    <label>Old Password</label>
                    <input type="password" class="input-xlarge" name="old_password">
                    <br>
                    <label>New Password</label>
                    <input type="password" class="input-xlarge" name="new_password">
                    <br>
                    <label>Confrim Password</label>
                    <input type="password" class="input-xlarge" name="confirm_password">
                    <div>
                        <button class="btn btn-primary" type="submit">Change Password</button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="orders">
                <br>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->date}}</td>
                            <td>{{$order->address}}</td>
                            <td>{{$order->status}}</td>
                            <td>
                                <a href="/myOrder/{{ $order->id }}/details" class="btn btn-primary">Details</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

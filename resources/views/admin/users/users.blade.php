@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Users</h4>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="stripe" id="myTable">
                            <thead class=" text-primary">
                            <th style="text-align: center">First Name</th>
                            <th style="text-align: center">Last Name</th>
                            <th style="text-align: center">Email</th>
                            <th style="text-align: center">Address</th>
                            <th style="text-align: center">Phone Number</th>
                            <th style="text-align: center">Role</th>
                            <th style="text-align: center">DELETE</th>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td style="width: 250px;">
                                    <form action="{{route('updateUser',["id"=>$user->user_id])}}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <select name="role" class="form-control" style="display: inline;width: 80px">
                                            @foreach($roles as $role)
                                                @if($role->id == $user->role_id)
                                                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                                @else
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button class="btn btn-info" style="display: inline">Change</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route('deleteUser',["id"=>$user->user_id])}}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">DELETE</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endsection

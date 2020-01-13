@extends('layout.main_layout')

@section('title')
    Manage Users
@endsection

@section('content')

@if (session()->has('success'))
    <div class="alert alert-success text-center" role="alert">
        {{ session('success') }}    
    </div>
@endif

@if ($errors->has('operation_failed'))
    <div class="alert alert-danger text-center" role="alert">
        {{ $errors->first('operation_failed') }}    
    </div>
@endif

<div class="row">
    <div class="col-sm-4 ml-auto">
        <form action="{{ route('user.search') }}" method="GET">
            <div class="form-group row">
                <div class="col-sm-8">
                    <input class="form-control" id="q" name="q" placeholder="Email">
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive-sm text-sm">
    <table class="table">
        <thead>
          <tr>
            <th scope="col" class="text-center">Picture</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Gender</th>
            <th scope="col">Address</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody class="table-borderless">
            @foreach ($users as $user)
                <tr>
                    <td class="align-middle text-center">
                        <img src="{{ asset('storage/'.$user->profile_picture) }}" class="rounded-circle" 
                        width="150px" height="150px">
                    </td>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">{{ $user->phone }}</td>
                    <td class="align-middle">{{ ucfirst($user->gender) }}</td>
                    <td class="align-middle">{{ $user->address }}</td>
                    <td class="align-middle">
                        <form action="{{ route('user.edit_admin', $user->id) }}" method="GET">
                            <button type="submit" class="btn btn-warning btn-sm btn-block">
                                <span class="btn-label-small btn-label-dark">Update</span>
                            </button>
                        </form>
                        <form action="{{ route('user.delete', $user->id) }}" method="POST">
                            {{ csrf_field() }}
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-block">
                                <span class="btn-label-small btn-label-dark">Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
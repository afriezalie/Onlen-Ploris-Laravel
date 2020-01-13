@extends('layout.main_layout')

@section('title')
    Manage Couriers
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
        <form action="{{ route('courier.search') }}" method="GET">
            <div class="form-group row">
                <div class="col-sm-8">
                    <input class="form-control" id="q" name="q" placeholder="Search">
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col text-center">
        <a href="{{ route('courier.create') }}" class="btn btn-primary text-center">Insert Courier</a>
    </div>
</div>

@foreach ($couriers_col->chunk(5) as $couriers)
    <div class="row my-4">
        @foreach ($couriers as $courier)        
            <div class="col-sm-2 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center">
                            ID {{ $courier->id }}
                        </div>
                        <div class="row">
                            <div class="col text-center">{{ $courier->name }}</div>
                        </div>
                        <div class="row my-2">
                            <div class="col text-center">Cost Rp. {{ $courier->cost}}</div>
                        </div>
                        <div class="row">
                            <form action="{{ route('courier.edit', $courier->id) }}" method="GET" class="mx-auto">
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <span class="btn-label-small btn-label-dark">Update</span>
                                </button>
                            </form>
                            <form action="{{ route('courier.delete', $courier->id) }}" method="POST" class="mx-auto">
                                {{ csrf_field() }}
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <span class="btn-label-small btn-label-dark">Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach

<div class="op-paginate paginate-link-right">
    {{ $couriers_col->links() }}
</div>

@endsection
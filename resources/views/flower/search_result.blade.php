@extends('layout.main_layout')

@section('title')
    Catalog
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

@if ($errors->has('quantity'))
    <div class="alert alert-danger text-center" role="alert">
        {{ $errors->first('quantity') }}    
    </div>
@endif

<div class="row">
    <div class="col-sm-4 ml-auto">
        <form action="{{ route('flower.search') }}" method="GET">
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

@foreach ($results->chunk(5) as $flowers)
    <div class="row my-4">
        @foreach ($flowers as $flower)        
            <div class="col-sm-2 mx-auto">
                <div class="card h-100">
                    <img src="{{ asset('storage/'.$flower->image) }}" height="150px" class="card-img-top">
                    <div class="card-body">
                        <div class="card-title text-center">{{ $flower->name }}</div>

                        <div class="row mb-2">
                            <div class="col text-sm">{{ Str::limit($flower->description, 20) }}</div>
                        </div>

                        <div class="row">
                            <form action="{{ route('flower.show', $flower->id) }}" method="GET" class="mx-auto">
                                <button type="submit" class="btn btn-warning btn-sm btn-block">
                                    <span class="btn-label-small btn-label-dark">Detail</span>
                                </button>
                            </form>
                            <form action="{{ route('cart.add_item', $flower->id) }}" method="POST" class="mx-auto">
                                {{ csrf_field() }}
                                <input type="hidden" id="quantity" name="quantity" value="1">
                                <button type="submit" class="btn btn-danger btn-sm btn-block">
                                    <span class="btn-label-small btn-label-dark">Order</span>
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
    {{ $results->appends(['q' => $query])->links() }}
</div>

@endsection
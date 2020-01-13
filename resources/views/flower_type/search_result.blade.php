@extends('layout.main_layout')

@section('title')
    Manage Flower Types
@endsection

@section('content')

<div class="row">
    <div class="col-sm-4 ml-auto">
        <form action="{{ route('flower_type.search') }}" method="GET">
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
        <a href="{{ route('flower_type.create') }}" class="btn btn-primary text-center">Insert Flower Type</a>
    </div>
</div>

@foreach ($results->chunk(5) as $types)
    <div class="row my-4">
        @foreach ($types as $type)        
            <div class="col-sm-2 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center">
                            {{ $type->name }}
                        </div>
                        <div class="row">
                            <form action="{{ route('flower_type.edit', $type->id) }}" method="GET" class="col-sm-5">
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <span class="btn-label-small btn-label-dark">Update</span>
                                </button>
                            </form>
                            <form action="{{ route('flower_type.delete', $type->id) }}" method="POST" class="col-sm-5">
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
    {{ $results->appends(['q' => $query])->links() }}
</div>

@endsection
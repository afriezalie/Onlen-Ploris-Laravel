@extends('layout.main_layout')

@section('title')
    Flower Detail
@endsection

@section('content')

<div class="row">
    <div class="col-sm-3 d-flex align-items-center">
        <img src="{{ asset('storage/'.$flower->image) }}" width="100%">
    </div>
    <div class="col-sm-9">
        <div class="op-detail d-flex flex-column h-100">

            <div class="op-detail-title mb-2">{{ $flower->name }}</div>

            {{ $flower->description }}

            <form action="{{ route('cart.add_item', $flower->id) }}" method="POST" class="mt-auto">
                {{ csrf_field() }}
                <div class="row align-items-center">
                    <div class="col-sm-2">
                        Stock: {{ $flower->stock }}
                        <input type="number" class="form-control form-control-sm 
                        {{ $errors->has('quantity') ? 'is-invalid' : ''}}" id="quantity" name="quantity">
                        @if ($errors->has('quantity'))
                            <div class="invalid-feedback">
                                {{ $errors->first('quantity') }}
                            </div>
                        @endif
                    </div>
                    <div class="op-detail-price col-sm-3 offset-sm-3">Rp. {{ $flower->price }}</div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
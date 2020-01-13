@extends('layout.main_layout')

@section('title')
    Cart
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

@if (!isset($flowers))
    <div class="text-center">Your cart is empty.</div>
@else
    @php
        $total_price = 0;
    @endphp

    <div class="table-responsive-sm text-sm">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Picture</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
            </thead>
            <tbody class="table-borderless">
                @foreach ($flowers as $flower)
                    <tr>
                        <td class="align-middle">
                            <img src="{{ asset('storage/'.$flower->image) }}" width="150px" height="150px">
                        </td>
                        <td class="align-middle">{{ $flower->name }}</td>
                        <td class="align-middle">{{ $flower->pivot->qty }}</td>
                        <td class="align-middle">{{ $flower->price }}</td>
                        <td class="align-middle text-center">
                            <form action="{{ route('cart.delete_item', $flower->id) }}" method="POST">
                                {{ csrf_field() }}
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <span class="btn-label-small btn-label-dark">Remove</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @php
                        $total_price += $flower->price * $flower->pivot->qty;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-6">

            <form action="{{ route('transaction.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Courier</label>
                    <div class="col-sm-7">
                        <select class="form-control {{ $errors->has('courier') ? 'is-invalid' : '' }}" 
                        id="courier" name="courier">
                            <option value="" selected disabled>Select courier</option>
                            @foreach ($couriers as $courier)
                                <option value="{{ $courier->id }}">{{ $courier->name.' - '. $courier->cost}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('courier'))
                            <div class="invalid-feedback">{{ $errors->first('courier') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-sm-4">Total Price</div>
                    <div class="col-sm-4">Rp. {{ $total_price }}</div>
                    <div class="col-sm-2 offset-sm-1">
                        <button type="submit" class="btn btn-sm btn-primary">Checkout</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endif

@endsection
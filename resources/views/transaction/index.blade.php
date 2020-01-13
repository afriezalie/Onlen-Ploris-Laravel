@extends('layout.main_layout')

@section('title')
    Transaction History
@endsection

@section('content')

@if ($transactions->isEmpty())
    <div class="text-center">No transaction history.</div>
@endif

@foreach ($transactions as $transaction)

    @php
        $total_price = 0;
    @endphp

    <div class="row">
        <div class="col-sm-3">Transaction ID</div>
        <div class="col-sm-3">{{ $transaction->id }}</div>
    </div>
    <div class="row">
        <div class="col-sm-3">Transaction Date</div>
        <div class="col-sm-3">{{ $transaction->created_at }}</div>
    </div>
    <div class="row">
        <div class="col-sm-3">Member Name</div>
        <div class="col-sm-3">{{ $transaction->user->name }}</div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Courier</div>
        <div class="col-sm-3">{{ $transaction->courier->name }}</div>
    </div>

    <div class="table-responsive-sm text-sm mb-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody class="table-borderless">
                @foreach ($transaction->flowers as $flower)
                    <tr class="border-bottom">
                        <td class="align-middle">
                            <img src="{{ asset('storage/'.$flower->image) }}" width="150px" height="150px">
                        </td>
                        <td class="align-middle">{{ $flower->name }}</td>
                        <td class="align-middle">{{ $flower->pivot->qty }}</td>
                        <td class="align-middle">{{ $flower->price }}</td>
                    </tr>
                    @php
                        $total_price += $flower->price * $flower->pivot->qty;
                    @endphp
                @endforeach
                <tr class="font-weight-bold">
                    <td></td>
                    <td>Total</td>
                    <td></td>
                    <td>Rp. {{ $total_price }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endforeach

@endsection
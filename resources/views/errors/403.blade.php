@extends('layout.error_layout')

@section('title')
    403 - Forbidden
@endsection

@section('content')

<div class="row">
    <div class="col-sm-6 offset-sm-3">
        <div class="font-weight-bold text-center text-800">
            403 :(
        </div>
        <div class="text-center">{{ $exception->getMessage() }}</div>
    </div>
</div>

@endsection
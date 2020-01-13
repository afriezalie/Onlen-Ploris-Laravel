@extends('layout.main_layout')

@section('title')
    Login
@endsection

@section('content')

<div class="row">
    <div class="col-6 mx-auto">
        @if ($errors->has('login_failed'))
            <div class="alert alert-danger text-center" role="alert">
                {{ $errors->first('login_failed') }}    
            </div>
        @endif

        <form action="{{ route('login') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">E-mail Address</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" name="email">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-4 col-form-label">Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-4 col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="isRememberMe" name="isRememberMe">
                        <label class="form-check-label" for="isRememberMe">Remember Me</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="mx-auto">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@extends('layout.main_layout')

@section('title')
    Update Courier
@endsection

@section('content')

<div class="row">
    <div class="col-6 mx-auto">    
        <form action="{{ route('courier.update', $courier->id) }}" method="POST">
            {{ csrf_field() }}
            @method('PUT')
            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Courier ID</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="id" name="id" value="{{ $courier->id }}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Courier Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                    id="name" name="name" value="{{ old('name') }}" placeholder="{{ $courier->name }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="cost" class="col-sm-4 col-form-label">Shipping Cost</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control {{ $errors->has('cost') ? 'is-invalid' : '' }}" 
                    id="cost" name="cost" value="{{ old('cost') }}" placeholder="{{ $courier->cost }}">
                    @if ($errors->has('cost'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cost') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="mx-auto">
                    <button type="submit" class="btn btn-primary">Insert</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
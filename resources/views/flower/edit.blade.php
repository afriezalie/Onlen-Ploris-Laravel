@extends('layout.main_layout')

@section('title')
    Update Flower
@endsection

@section('content')

<div class="row">
    <div class="col-6 mx-auto">
        <form action="{{ route('flower.update', $flower->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Flower Name</label>
                <div class="col-sm-8">
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                id="name" name="name" value="{{ old('name') }}" placeholder="{{ $flower->name }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="price" class="col-sm-4 col-form-label">Flower Price</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" 
                    id="price" name="price" value="{{ old('price') }}" placeholder="{{ $flower->price }}">
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="stock" class="col-sm-4 col-form-label">Flower Stock</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" 
                    id="stock" name="stock" value="{{ old('stock') }}" placeholder="{{ $flower->stock }}">
                    @if ($errors->has('stock'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="type" class="col-sm-4 col-form-label">Flower Type</label>
                <div class="col-sm-8">
                    <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" id="type" name="type">
                        <option value="" selected disabled>Select flower type</option>
                        @foreach ($flower_types as $type)
                            <option 
                            value="{{ $type->id }}" 
                            @if (old('type'))
                                {{ old('type') == $type->id ? 'selected' : ''}}
                            @else
                                {{ $flower->type_id == $type->id ? 'selected' : ''}}
                            @endif
                            >{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('type'))
                        <div class="invalid-feedback">
                            {{ $errors->first('type') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Flower Description</label>
                <div class="col-sm-8">
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" 
                    rows="5" id="description" name="description" 
                    placeholder="{{ $flower->description }}">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-sm-4 col-form-label pt-0">Image</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control-file {{ $errors->has('image') ? 'is-invalid' : '' }}" 
                    id="image" name="image">
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="mx-auto">
                    <button type="submit" class="btn btn-primary">Update Flower</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
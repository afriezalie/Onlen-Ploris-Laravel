@extends('layout.main_layout')

@section('title')
    Profile
@endsection

@section('content')

<div class="row">
    <div class="col-6 mx-auto">
        <form action="{{ route('user.update') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Name</label>
                <div class="col-sm-8">
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                id="name" name="name" value="{{ old('name') }}" placeholder="{{ $user->name }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">E-mail Address</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    id="email" name="email" value="{{ old('email') }}" placeholder="{{ $user->email }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-sm-4 col-form-label">Phone Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" 
                    id="phone" name="phone" value="{{ old('phone') }}" placeholder="{{ $user->phone }}">
                    @if ($errors->has('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                </div>
            </div>

            <fieldset class="form-group">
                <div class="row">
                    <legend class="col-form-label col-sm-4 pt-0">Gender</legend>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input class="form-check-input {{ $errors->has('gender') ? 'is-invalid' : '' }}" 
                            type="radio" name="gender" id="radioMale" value="male" 
                            @if (old('gender'))
                                {{ old('gender') == 'male' ? 'checked' : ''}}
                            @else
                                {{ $user->gender == 'male' ? 'checked' : ''}}
                            @endif
                            >
                            <label class="form-check-label" for="radioMale">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input {{ $errors->has('gender') ? 'is-invalid' : '' }}" 
                            type="radio" name="gender" id="radioFemale" value="female" 
                            @if (old('gender'))
                                {{ old('gender') == 'female' ? 'checked' : ''}}
                            @else
                                {{ $user->gender == 'female' ? 'checked' : '' }}
                            @endif
                            >
                            <label class="form-check-label" for="radioFemale">Female</label>
                            @if ($errors->has('gender'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gender') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="form-group row">
                <label for="address" class="col-sm-4 col-form-label">Address</label>
                <div class="col-sm-8">
                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" 
                    rows="5" id="address" name="address" 
                    placeholder="{{ $user->address }}">{{ old('address') }}</textarea>
                    @if ($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
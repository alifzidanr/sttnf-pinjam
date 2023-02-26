@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.room.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.rooms.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.room.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}"  >
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.room.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="capacity">{{ trans('cruds.room.fields.capacity') }}</label>
                <input class="form-control {{ $errors->has('capacity') ? 'is-invalid' : '' }}" type="number" name="capacity" id="capacity" value="{{ old('capacity', '') }}" step="1" min="10" max="100" required>
                @if($errors->has('capacity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('capacity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.room.fields.capacity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.room.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.room.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="location">{{ trans('cruds.room.fields.location') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', '') }}" required>
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.room.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="resp">{{ trans('cruds.room.fields.resp') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="resp" id="resp" value="{{ old('resp', '') }}" required>
                @if($errors->has('resp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('resp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.room.fields.resp_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="resp_no">{{ trans('cruds.room.fields.resp_no') }}</label>
                <input class="form-control {{ $errors->has('resp_no') ? 'is-invalid' : '' }}" pattern="[0-9]{12}" type="text" name="resp_no" id="resp_no" value="{{ old('resp_no', '') }}" required>
                @if($errors->has('resp_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('resp_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.room.fields.resp_no_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.room.fields.email') }}</label>
                <input class="form-control {{ $errors->has('resp_no') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', '') }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.room.fields.email_helper') }}</span>
            </div>

            {{-- <div class="form-group">
                <label for="hourly_rate">{{ trans('cruds.room.fields.hourly_rate') }}</label>
                <input class="form-control {{ $errors->has('hourly_rate') ? 'is-invalid' : '' }}" type="number" name="hourly_rate" id="hourly_rate" value="{{ old('hourly_rate', '') }}" step="0.01">
                @if($errors->has('hourly_rate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hourly_rate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.room.fields.hourly_rate_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
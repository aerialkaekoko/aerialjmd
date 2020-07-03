@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.localInsurance.title_singular') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("admin.local-insurances.update", [$localInsurance->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                            <label for="company_name">{{ trans('cruds.localInsurance.fields.company_name') }}</label>
                            <input class="form-control" type="text" name="company_name" id="company_name" value="{{ old('company_name', $localInsurance->company_name) }}">
                            @if($errors->has('company_name'))
                                <span class="help-block" role="alert">{{ $errors->first('company_name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.localInsurance.fields.company_name_helper') }}</span>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-info" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
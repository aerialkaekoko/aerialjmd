@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.membership.title_singular') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("admin.memberships.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                            <label for="company_name">{{ trans('cruds.membership.fields.company_name') }}</label>
                            <input class="form-control" type="text" name="company_name" id="company_name" value="{{ old('company_name', '') }}">
                            @if($errors->has('company_name'))
                                <span class="help-block" role="alert">{{ $errors->first('company_name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.membership.fields.company_name_helper') }}</span>
                        </div>
                            </div>
                            <div class="col-md-6">                   
                                <div class="form-group {{ $errors->has('membership_short_code') ? 'has-error' : '' }}">
                                    <label for="membership_short_code">Short Code</label>
                                    <input type="text" id="membership_short_code" name="membership_short_code" class="form-control" value="{{ old('membership_short_code', '') }}" >
                                    @if($errors->has('membership_short_code'))
                                        <p class="help-block">
                                                {{ $errors->first('membership_short_code') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
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
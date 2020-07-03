@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.invoice_description.title_singular') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("admin.invoice_descriptions.update", [$invoice_description->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description">{{ trans('cruds.invoice_description.fields.description') }}</label>
                            <input class="form-control" type="text" name="description" id="description" value="{{ old('description', $invoice_description->description) }}">
                            @if($errors->has('description'))
                                <span class="help-block" role="alert">{{ $errors->first('description') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice_description.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-info" type="submit">
                                {{ trans('global.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
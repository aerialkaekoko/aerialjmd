@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.exchange.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.exchanges.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('exchange_thb') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.exchange.fields.thb') }}</label>
                        <input type="number" id="exchange_thb" name="exchange_thb" class="form-control text-right" value="0">
                        @if($errors->has('exchange_thb'))
                            <p class="help-block">
                                {{ $errors->first('exchange_thb') }}
                            </p>
                        @endif                    
                    </div>                    
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('exchange_lak') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.exchange.fields.lak') }}</label>
                        <input type="number" id="exchange_lak" name="exchange_lak" class="form-control text-right" value="0">
                        @if($errors->has('exchange_lak'))
                            <p class="help-block">
                                {{ $errors->first('exchange_lak') }}
                            </p>
                        @endif                    
                    </div>                    
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('exchange_mmk') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.exchange.fields.mmk') }}</label>
                        <input type="number" id="exchange_mmk" name="exchange_mmk" class="form-control text-right" value="0">
                        @if($errors->has('exchange_mmk'))
                            <p class="help-block">
                                {{ $errors->first('exchange_mmk') }}
                            </p>
                        @endif                    
                    </div>                    
                </div>
            </div>
            <div>
                <input class="btn btn-primary" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>    
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@stop
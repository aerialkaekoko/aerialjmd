@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.exchange.title_singular') }}
    </div>

    <div class="card-body">
        <h6>Note : Exchnage  Rate is based on USD($). For example:</h6>
        <p style="margin-left: 30px;font-weight: bold;font-size: 15px;">
            1 USD = 31.10 THB <br/>
            1 USD = 1,394.02 MMK <br/>
            1 USD = 9,060.00 LAK
        </p>
        <hr/>
        <form action="{{ route("admin.exchanges.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('exchange_usd') ? 'has-error' : '' }}">
                        <label for="name">USD</label>
                        <input type="text" id="exchange_usd" name="exchange_usd" class="form-control text-right" onkeypress="return isNumberKey(event)" value="0">
                        @if($errors->has('exchange_usd'))
                            <p class="help-block">
                                {{ $errors->first('exchange_usd') }}
                            </p>
                        @endif                    
                    </div>                    
                </div>
                 <div class="col-md-6">
                    <div class="form-group {{ $errors->has('exchange_thb') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.exchange.fields.thb') }}</label>
                        <input type="text" id="exchange_thb" name="exchange_thb" class="form-control text-right" onkeypress="return isNumberKey(event)" value="0">
                        @if($errors->has('exchange_thb'))
                            <p class="help-block">
                                {{ $errors->first('exchange_thb') }}
                            </p>
                        @endif                    
                    </div>                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('exchange_mmk') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.exchange.fields.mmk') }}</label>
                        <input type="text" id="exchange_mmk" name="exchange_mmk" class="form-control text-right" onkeypress="return isNumberKey(event)" value="0">
                        @if($errors->has('exchange_mmk'))
                            <p class="help-block">
                                {{ $errors->first('exchange_mmk') }}
                            </p>
                        @endif                    
                    </div>                    
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('exchange_lak') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.exchange.fields.lak') }}</label>
                        <input type="text" id="exchange_lak" name="exchange_lak" class="form-control text-right" onkeypress="return isNumberKey(event)" value="0">
                        @if($errors->has('exchange_lak'))
                            <p class="help-block">
                                {{ $errors->first('exchange_lak') }}
                            </p>
                        @endif                    
                    </div>                    
                </div>
                
            </div>
            <div class="text-right">
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
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
    }
</script>
@stop
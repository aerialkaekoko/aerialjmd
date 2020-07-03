@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.insurance.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.insurances.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                    <label for="company_name">{{ trans('cruds.insurance.fields.company_name') }}*</label>
                    <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name', isset($insurance) ? $insurance->company_name : '') }}" required="">
                    @if($errors->has('company_name'))
                        <p class="help-block">
                            {{ $errors->first('company_name') }}
                        </p>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.insurance.fields.company_name_helper') }}
                    </p>
                </div>
              </div>              
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                  <label for="phone">{{ trans('cruds.insurance.fields.phone') }}</label>
                  <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($insurance) ? $insurance->phone : '') }}">
                  @if($errors->has('phone'))
                      <p class="help-block">
                          {{ $errors->first('phone') }}
                      </p>
                  @endif
                  <p class="helper-block">
                      {{ trans('cruds.insurance.fields.phone_helper') }}
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('template') ? 'has-error' : '' }}">
                    <label for="template">template</label>
                    <input type="text" id="template" name="template" class="form-control"
                        value="{{ old('template', isset($insurance) ? $insurance->template : '') }}">
                    @if($errors->has('template'))
                    <p class="help-block">
                        {{ $errors->first('template') }}
                    </p>
                    @endif                  
                </div>
              </div>
            </div>
            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('cruds.insurance.fields.address') }}</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($insurance) ? $insurance->address : '') }}">
                @if($errors->has('address'))
                    <p class="help-block">
                        {{ $errors->first('address') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.insurance.fields.address_helper') }}
                </p>
            </div>

            

            <div class="form-group">
                <label for="template_pdf">{{ trans('cruds.insurance.fields.template_pdf') }}</label>
                <div class="needsclick dropzone {{ $errors->has('template_pdf') ? 'is-invalid' : '' }}" id="template_pdf-dropzone">
                </div>
                @if($errors->has('template_pdf'))
                <span class="text-danger">{{ $errors->first('template_pdf') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.insurance.fields.template_pdf_helper') }}</span>
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
    Dropzone.options.templatePdfDropzone = {
    url: '{{ route('admin.insurances.storeMedia') }}',
    maxFilesize: 6, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 6
    },
    success: function (file, response) {
      $('form').find('input[name="template_pdf"]').remove()
      $('form').append('<input type="hidden" name="template_pdf" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="template_pdf"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($insurance) && $insurance->template_pdf)
      var file = {!! json_encode($insurance->template_pdf) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="template_pdf" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
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
@endsection


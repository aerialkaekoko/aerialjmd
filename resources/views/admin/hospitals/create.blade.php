@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.hospitals.title_singular') }}
    </div>

    <div class="card-body hospitals-create">
        <form action="{{ route("admin.hospitals.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                  <label for="name">{{ trans('cruds.hospitals.fields.name') }}*</label>
                  <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($hospitals) ? $hospitals->name : '') }}" required="">
                  @if($errors->has('name'))
                      <p class="help-block">
                          {{ $errors->first('name') }}
                      </p>
                  @endif                
              </div>
              </div>
            </div>           

            <div class="row">
              <div class="col-md-6">
                  <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                    <label for="country">{{ trans('cruds.hospitals.fields.country') }}*</label>
                    <select name="country" id="country" class="form-control" required="">
                        @foreach(trans( 'cruds.countries' ) as $id => $country)
                            <option value="{{ $id }}" >{{ $country }}</option>
                        @endforeach
                    </select>                
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group {{ $errors->has('country_code') ? 'has-error' : '' }}">
                    <label for="country_code">{{ trans('cruds.hospitals.fields.country_code') }}*</label>
                    <input type="text" id="country_code" name="country_code" class="form-control" value="{{ old('country_code', isset($hospitals) ? $hospitals->country_code : '') }}" required="">
                    @if($errors->has('country_code'))
                        <p class="help-block">
                            {{ $errors->first('country_code') }}
                        </p>
                    @endif
                  </div>
              </div>        
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address">{{ trans('cruds.hospitals.fields.address') }}</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($hospitals) ? $hospitals->address : '') }}">
                    @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                    @endif                
                </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
                    <label for="contact">{{ trans('cruds.hospitals.fields.contact') }}</label>
                      <input type="text" id="contact" name="contact" class="form-control" value="{{ old('contact', isset($hospitals) ? $hospitals->contact : '') }}">
                          @if($errors->has('contact'))
                              <p class="help-block">
                                  {{ $errors->first('contact') }}
                              </p>
                          @endif                          
                   </div>
              </div>
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('cruds.hospitals.fields.description') }}</label>
                <textarea id="description" name="description" class="form-control ckeditor">{{ old('description', isset($hospitals) ? $hospitals->description : '') }}</textarea>
                @if($errors->has('description'))
                    <p class="help-block">
                        {{ $errors->first('description') }}
                    </p>
                @endif                
            </div>           
           
            <div class="text-right">
                <input class="btn btn-info" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var uploadedHospitalsImagesMap = {}
Dropzone.options.hospitalsImagesDropzone = {
    url: '{{ route('admin.hospitals.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="hospitals_images[]" value="' + response.name + '">')
      uploadedHospitalsImagesMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedHospitalsImagesMap[file.name]
      }
      $('form').find('input[name="hospitals_images[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($hospitals) && $hospitals->hospitals_images)
      var files =
        {!! json_encode($hospitals->hospitals_images) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="hospitals_images[]" value="' + file.file_name + '">')
        }
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
@stop
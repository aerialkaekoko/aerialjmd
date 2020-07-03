@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Diagnosis
    </div>

    <div class="card-body">
        <form action="{{ route("admin.medicals.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('disease_name') ? 'has-error' : '' }}">
                <label for="disease_name">Diagnosis Name *</label>
                <input type="text" id="disease_name" name="disease_name" class="form-control" value="{{ old('disease_name', isset($medicals) ? $medicals->disease_name : '') }}" required>
                @if($errors->has('disease_name'))
                    <p class="help-block">
                        {{ $errors->first('disease_name') }}
                    </p>
                @endif
                <p class="helper-block">
                  Diagnosis
                </p>
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
Dropzone.options.medicalsImagesDropzone = {
    url: '{{ route('admin.medicals.storeMedia') }}',
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
      $('form').append('<input type="hidden" name="medicals_images[]" value="' + response.name + '">')
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
      $('form').find('input[name="medicals_images[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($medicals) && $medicals->medicals_images)
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
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userAlert.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.user-alerts.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('alert_text') ? 'has-error' : '' }}">
                <label for="alert_text">{{ trans('cruds.userAlert.fields.alert_text') }}*</label>
                <input type="text" id="alert_text" name="alert_text" class="form-control" value="{{ old('alert_text', isset($userAlert) ? $userAlert->alert_text : '') }}" required>
                @if($errors->has('alert_text'))
                    <p class="help-block">
                        {{ $errors->first('alert_text') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.userAlert.fields.alert_text_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('users') ? 'has-error' : '' }}">
                <label for="user">{{ trans('cruds.userAlert.fields.user') }}
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="users[]" id="users" class="form-control select2" multiple="multiple">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (in_array($id, old('users', [])) || isset($userAlert) && $userAlert->users->contains($id)) ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('users'))
                    <p class="help-block">
                        {{ $errors->first('users') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.userAlert.fields.user_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
                <label for="file">{{ trans('cruds.userAlert.fields.file') }}</label>
                <div class="needsclick dropzone" id="file-dropzone">

                </div>
                @if($errors->has('file'))
                    <p class="help-block">
                        {{ $errors->first('file') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.userAlert.fields.file_helper') }}
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
    var uploadedFileMap = {}
Dropzone.options.fileDropzone = {
    url: '{{ route('admin.user-alerts.storeMedia') }}',
    maxFilesize: 200, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 200
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="file[]" value="' + response.name + '">')
      uploadedFileMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFileMap[file.name]
      }
      $('form').find('input[name="file[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($userAlert) && $userAlert->file)
          var files =
            {!! json_encode($userAlert->file) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="file[]" value="' + file.file_name + '">')
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
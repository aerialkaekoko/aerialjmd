@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- <div class="form-group {{ $errors->has('fname') ? 'has-error' : '' }}">
                <label for="fname">{{ trans('cruds.user.fields.fname') }}</label>
                <input type="text" id="fname" name="fname" class="form-control"
                    value="{{ old('fname', isset($user) ? $user->family_name : '') }}" required>
                @if($errors->has('fname'))
                <p class="help-block">
                    {{ $errors->first('fname') }}
                </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.fname_helper') }}
                </p>
            </div> --}}

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                @if($errors->has('name'))
                <p class="help-block">
                    {{ $errors->first('name') }}
                </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                @if($errors->has('email'))
                <p class="help-block">
                    {{ $errors->first('email') }}
                </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('approved') ? 'has-error' : '' }}">
                <label for="approved">{{ trans('cruds.user.fields.approved') }}</label>
                <input name="approved" type="hidden" value="0">
                <input value="1" type="checkbox" id="approved" name="approved"
                    {{ (isset($user) && $user->approved) || old('approved', 0) === 1 ? 'checked' : '' }}>
                @if($errors->has('approved'))
                <p class="help-block">
                    {{ $errors->first('approved') }}
                </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.approved_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input type="password" id="password" name="password" class="form-control">
                @if($errors->has('password'))
                <p class="help-block">
                    {{ $errors->first('password') }}
                </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.password_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('cruds.user.fields.roles') }}*</label>
                <select name="roles[]" id="roles" class="form-control select2" required>
                    @foreach($roles as $id => $roles)
                    <option value="{{ $id }}"
                        {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                        {{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                <p class="help-block">
                    {{ $errors->first('roles') }}
                </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.roles_helper') }}
                </p>
            </div>
             <div class="form-group">
                <label for="permissions">{{ trans('cruds.user.fields.permission') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple>
                    @foreach($permissions as $id => $permission)
                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $user->permissions->contains($id)) ? 'selected' : '' }}>{{ $permission}}</option>
                    @endforeach
                </select>
                @if($errors->has('permissions'))
                    <span class="text-danger">{{ $errors->first('permissions') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.permission_helper') }}</span>
            </div>

            <!-- Countries -->
            <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                <label for="country">{{ trans('cruds.members.fields.country') }}</label>
                <select id="country" name="country" class="form-control" required>
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach(trans('cruds.countries') as $key => $label)
                    <option value="{{ $key }}" {{ old( 'country', $user->country)===( string)$key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                <p class="help-block">
                    {{ $errors->first('country') }}
                </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.members.fields.country_helper') }}
                </p>
            </div>
            <!-- end Countries -->

       
            <div class="text-right">
                <input class="btn btn-info" type="submit" value="{{ trans('global.update') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
    var uploadedPassportInfoMap = {}
Dropzone.options.passportInfoDropzone = {
    url: '{{ route('admin.users.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="passport_info[]" value="' + response.name + '">')
      uploadedPassportInfoMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPassportInfoMap[file.name]
      }
      $('form').find('input[name="passport_info[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($user) && $user->passport_info)
          var files =
            {!! json_encode($user->passport_info) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="passport_info[]" value="' + file.file_name + '">')
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
<script>
    var uploadedInsuranceMap = {}
Dropzone.options.insuranceDropzone = {
    url: '{{ route('admin.users.storeMedia') }}',
    maxFilesize: 6, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 6
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="insurance[]" value="' + response.name + '">')
      uploadedInsuranceMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedInsuranceMap[file.name]
      }
      $('form').find('input[name="insurance[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($user) && $user->insurance)
          var files =
            {!! json_encode($user->insurance) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="insurance[]" value="' + file.file_name + '">')
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
    <script type="text/javascript">
    
      $(document).ready(function(){
            $("#roles").change(function(){
            $.ajax({
                 method: 'GET',
                // url: "{{ url('admin/permissions/get_by_role') }}?role_id=" + $(this).val(),
                url :'/admin/permissions/get_by_role/'+$(this).val(),
                success: function(data) {
                     $('#permissions option').remove();
                   $('#permissions').html(data.html);
                }
            });
        });
      });
    </script>
@stop
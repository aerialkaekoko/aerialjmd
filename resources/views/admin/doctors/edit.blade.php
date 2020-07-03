@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.doctors.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.doctors.update", [$doctor->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.doctors.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($doctor) ? $doctor->name : '') }}" required>
                        @if($errors->has('name'))
                            <p class="help-block">
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                        <!-- <p class="helper-block">
                            {{ trans('cruds.doctors.fields.name_helper') }}
                        </p> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('qualification') ? 'has-error' : '' }}">
                        <label for="qualification">{{ trans('cruds.doctors.fields.qualification') }}</label>
                        <input type="text" id="qualification" name="qualification" class="form-control" value="{{ old('qualification', isset($doctor) ? $doctor->qualification : '') }}">
                        @if($errors->has('qualification'))
                            <p class="help-block">
                                {{ $errors->first('qualification') }}
                            </p>
                        @endif
                        <!-- <p class="helper-block">
                            {{ trans('cruds.doctors.fields.qualification_helper') }}
                        </p> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('hospital_id') ? 'has-error' : '' }}">
                        <label for="hospitals">{{ trans('cruds.doctors.fields.hospital_id') }}*
                            <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                        <select name="hospital_id[]" id="hospitals" class="form-control select2" multiple="multiple" required>
                            @foreach($hospitals as $id => $hospitals)
                                <option value="{{ $id }}" {{ (in_array($id, old('hospitals', [])) || isset($user) && $user->hospitals->contains($id)) ? 'selected' : '' }}>{{ $hospitals }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('hospitals'))
                            <p class="help-block">
                                {{ $errors->first('hospitals') }}
                            </p>
                        @endif
                        <!-- <p class="helper-block">
                            {{ trans('cruds.doctors.fields.hospital_helper') }}
                        </p> -->
                    </div>
                </div>
                <div class="col-md-6">                    
                    <div class="form-group {{ $errors->has('specialist') ? 'has-error' : '' }}">
                        <label for="hospital_id">{{ trans('cruds.doctors.fields.specialist') }}</label>
                         <select name="specialist" id="specialist" class="form-control" required>
                            @foreach(trans( 'cruds.specialists' ) as $id => $specialist)
                                <option value="{{ $id }}" >{{ $specialist }}</option>
                            @endforeach
                        </select>
                        <!-- <p class="helper-block">
                            {{ trans('cruds.doctors.fields.specialist_helper') }}
                        </p> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('schedule') ? 'has-error' : '' }}">
                        <label for="schedule">{{ trans('cruds.doctors.fields.schedule') }}</label>
                        <input type="text" id="schedule" name="schedule" class="form-control" value="{{ old('schedule', isset($doctor) ? $doctor->schedule : '') }}">
                        @if($errors->has('schedule'))
                            <p class="help-block">
                                {{ $errors->first('schedule') }}
                            </p>
                        @endif
                        <!-- <p class="helper-block">
                            {{ trans('cruds.doctors.fields.schedule_helper') }}
                        </p> -->
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                        <label for="country">{{ trans('cruds.doctors.fields.country') }}</label>
                        {{--
                        <input type="text" id="country" name="country" class="form-control" value="{{ old('name', isset($doctor) ? $doctor->country : '') }}">
                        @if($errors->has('country'))
                            <p class="help-block">
                                {{ $errors->first('country') }}
                            </p>
                        @endif
                        --}}
                        <select name="country" id="country" class="form-control" required>
                            @foreach(trans( 'cruds.countries' ) as $id => $country)
                                <option value="{{ $id }}" >{{ $country }}</option>
                            @endforeach
                        </select>
                        <!-- <p class="helper-block">
                            {{ trans('cruds.doctors.fields.country_helper') }}
                        </p> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
                        <label for="contact">{{ trans('cruds.doctors.fields.contact') }}</label>
                        <input type="text" id="contact" name="contact" class="form-control" value="{{ old('name', isset($doctor) ? $doctor->contact : '') }}">
                        @if($errors->has('contact'))
                            <p class="help-block">
                                {{ $errors->first('contact') }}
                            </p>
                        @endif
                        <!-- <p class="helper-block">
                            {{ trans('cruds.doctors.fields.contact_helper') }}
                        </p> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        <label for="address">{{ trans('cruds.doctors.fields.address') }}</label>
                        <input type="text" id="address" name="address" class="form-control" value="{{ old('name', isset($doctor) ? $doctor->address : '') }}">
                        @if($errors->has('address'))
                            <p class="help-block">
                                {{ $errors->first('address') }}
                            </p>
                        @endif
                        <!-- <p class="helper-block">
                            {{ trans('cruds.doctors.fields.address_helper') }}
                        </p> -->
                    </div>
                </div>
            </div>
            
            {{-- 
            <div class="form-group {{ $errors->has('hospital_id') ? 'has-error' : '' }}">
                <label for="hospital_id">{{ trans('cruds.doctors.fields.hospital_id') }}</label>
                <input type="text" id="hospital_id" name="hospital_id" class="form-control" value="{{ old('hospital_id', isset($doctor) ? $doctor->hospital_id : '') }}">
                @if($errors->has('hospital_id'))
                    <p class="help-block">
                        {{ $errors->first('hospital_id') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.doctors.fields.hospital_helper') }}
                </p>
            </div> 
            --}}

            <div class="form-group {{ $errors->has('doctors_images') ? 'has-error' : '' }}">
                <label for="doctors_images">{{ trans('cruds.doctors.fields.doctors_images') }}</label>
                <div class="needsclick dropzone" id="doctors_images-dropzone">

                </div>
                @if($errors->has('doctors_image'))
                    <p class="help-block">
                        {{ $errors->first('doctors_images') }}
                    </p>
                @endif
                <!-- <p class="helper-block">
                    {{ trans('cruds.doctors.fields.doctors_images_helper') }}
                </p> -->
            </div>

            <div class="text-right">
                <input class="btn btn-info" type="submit" value="{{ trans('global.update') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
    var uploadedHospitalsImagesMap = {}
Dropzone.options.doctorsImagesDropzone = {
    url: '{{ route('admin.doctors.storeMedia') }}',
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
      $('form').append('<input type="hidden" name="doctors_images[]" value="' + response.name + '">')
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
      $('form').find('input[name="doctors_images[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($doctors) && $doctors->doctors_images)
      var files =
        {!! json_encode($doctors->doctors_images) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="doctors_images[]" value="' + file.file_name + '">')
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
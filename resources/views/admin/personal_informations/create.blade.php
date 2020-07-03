@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.personal_informations.title_singular') }}
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link " href="{{ route('admin.members.index') }}">Member Lists</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('admin.members.edit', $user->id) }}">Edit Member</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.user-insurances.create',['user_id'=>$user->id])}}">Member Insurance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#" id="personal-info">Personal Medical Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.medical_informations.index',['user_id'=>$user->id])}}" id="medical-info">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.medical_informations.title_singular') }}</a>
            </li>
        </ul>
    </div>
    <div class="card-body">        
        <form action="{{ route("admin.personal_informations.store",$user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="personal_id" value="{{isset($personalInformation)?$personalInformation->id : ''}}">
        <input type="hidden" name="user_id" value="{{$user->id}}">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                        <label for="user">{{ trans('cruds.userInsurance.fields.user') }}*</label>
                        <p class="text-danger">
                            @if($user->gender == "male")
                                Mr.
                            @else
                            Ms.
                            @endif
                            {{$user->family_name}} {{$user->name}}
                        </p>
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        @if($errors->has('user_id'))
                            <p class="help-block">
                                {{ $errors->first('user_id') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">                    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Hospital">Hospital 1 病院名 1 :</label>
                        <select name="hospital_id" id="hospital" class="form-control select2" >
                            @foreach($hospitals as $id => $hospital)
                                <option value="{{ $id }}" {{ (isset($personalInformation)? $personalInformation->hospital_id : old('hospital_id')) == $id ? 'selected' : '' }}>{{ $hospital }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('assistance_id1'))
                            <p class="help-block">
                                {{ $errors->first('assistance_id1') }}
                            </p>
                         @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Patient No">Hospital Patient No: 患者番号</label>
                     <input type="text" id="hospital_patient_no" name="hospital_patient_no" class="form-control" value="{{ old('hospital_patient_no', isset($personalInformation) ? $personalInformation->hospital_patient_no : '') }}" >
                    
                </div>
            </div>

            <div class="row">                    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Hospital">Hospital 2 病院名 2 :</label>
                        <select name="hospital2_id" id="hospital" class="form-control select2" >
                            @foreach($hospitals as $id => $hospital2)
                                <option value="{{ $id }}" {{ (isset($personalInformation)? $personalInformation->hospital2_id : old('hospital2_id')) == $id ? 'selected' : '' }}>{{ $hospital2 }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('assistance_id1'))
                            <p class="help-block">
                                {{ $errors->first('assistance_id1') }}
                            </p>
                         @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Patient No">Hospital2 Patient No: 患者番号</label>
                     <input type="text" id="hospital2_patient_no" name="hospital2_patient_no" class="form-control" value="{{ old('hospital2_patient_no', isset($personalInformation) ? $personalInformation->hospital2_patient_no : '') }}" >
                    
                </div>
            </div>
            <div class="row">                    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Hospital">Hospital 3 病院名 3 :</label>
                        <select name="hospital3_id" id="hospital3" class="form-control select2" >
                            @foreach($hospitals as $id => $hospital3)
                                <option value="{{ $id }}" {{ (isset($personalInformation)? $personalInformation->hospital3_id : old('hospital3_id')) == $id ? 'selected' : '' }}>{{ $hospital3 }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('assistance_id1'))
                            <p class="help-block">
                                {{ $errors->first('assistance_id1') }}
                            </p>
                         @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Patient No">Hospital3 Patient No: 患者番号</label>
                    <input type="text" id="hospital3_patient_no" name="hospital3_patient_no" class="form-control" value="{{ old('hospital3_patient_no', isset($personalInformation) ? $personalInformation->hospital3_patient_no : '') }}" >
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="Disease">Chronic Disease 慢性疾患:</label>
                    <input type="text" id="medicals" name="medicals" class="form-control" value="{{ old('medicals', isset($personalInformation) ? $personalInformation->medicals : '') }}" >
                </div>                
            </div><br/>

            <div class="row">
                <div class="col-md-6">
                    <label for="Patient No">Past Medical Hystory 既往歴</label>
                    <textarea class="form-control" id="medical_hystory" name="medical_hystory" rows="2">
                        {{ old('medical_hystory', isset($personalInformation) ? $personalInformation->medical_hystory : '') }}
                    </textarea>
                </div>
                <div class="col-md-6">
                    <label for="Sympton">Comments 自由記入欄</label>
                    <textarea class="form-control" id="comments" name="comments" rows="2">
                        {{ old('comments', isset($personalInformation) ? $personalInformation->comments : '') }}
                    </textarea>
                </div>
            </div>
            <br/>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('materials') ? 'has-error' : '' }}">
                    <label for="materials">Attached File 患者様持参の資料など</label>
                    <div class="needsclick dropzone" id="materials-dropzone">
                    </div>
                    @if($errors->has('materials'))
                        <p class="help-block">
                            {{ $errors->first('materials') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 text-right">
                <input class="btn btn-info" type="submit" value="{{ trans('global.update') }}">
            </div>
        </div>
           
        </form>
    </div>
</div>

@endsection
@section('scripts')
    <script src="{{asset('js/jquery-repeater.js')}}"></script>
    <script>
    var uploadedmaterialsMap = {}
    Dropzone.options.materialsDropzone = {
        url: '{{ route('admin.personal_informations.storeMedia') }}',
        maxFilesize: 5, // MB
        addRemoveLinks: true,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
          size: 5
        },
        success: function (file, response) {
          $('form').append('<input type="hidden" name="materials[]" value="' + response.name + '">')
          uploadedmaterialsMap[file.name] = response.name
        },
        removedfile: function (file) {
          file.previewElement.remove()
          var name = ''
          if (typeof file.file_name !== 'undefined') {
            name = file.file_name
          } else {
            name = uploadedmaterialsMap[file.name]
          }
          $('form').find('input[name="materials[]"][value="' + name + '"]').remove()
        },
        init: function () {
    @if(isset($personalInformation) && $personalInformation->materials)
              var files =
                {!! json_encode($personalInformation->materials) !!}
                  for (var i in files) {
                  var file = files[i]
                  this.options.addedfile.call(this, file)
                  file.previewElement.classList.add('dz-complete')
                  $('form').append('<input type="hidden" name="materials[]" value="' + file.file_name + '">')
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
@endsection
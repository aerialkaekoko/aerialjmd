@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.personal_informations.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.personal_informations.update", ['id'=>$personal_information->id,'user_id'=>$user_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="User">Patient *:</label>
                            <p class="text-danger">
                                @if(App\User::find($user_id)->gender == "male")
                                    Mr.
                                @else
                                    Ms.
                                @endif
                                {{$personal_information->user->family_name}} {{$personal_information->user->name}}</p>
                            <input type="hidden" name="user_id" value="{{$user_id}}">
                        </div>
                    </div>
                </div>                          
            </div>            
            <div class="row">                    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Hospital">Hospital 1 病院名 1 :</label>
                        <select class="form-control select2" id="hospital" name="hospital_id" >
                            @foreach($hospitals as $id => $hospital)
                                <option value="{{ $id }}" {{ (isset($personal_information) && $personal_information->hospital ? $personal_information->hospital->id : old('hospital_id')) == $id ? 'selected' : '' }} data-country="{{$id}}">{{ $hospital }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Patient No">Hospital Patient No: 患者番号</label>
                    <input type="text" id="hospital_patient_no" name="hospital_patient_no" class="form-control" value="{{$personal_information->hospital_patient_no}}">
                </div>
            </div>
            <div class="row">                    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Hospital">Hospital 2 病院名 2:</label>
                        <select class="form-control select2" id="hospital2" name="hospital2_id" >
                            @foreach($hospitals as $id => $hospital2)
                                <option value="{{ $id }}" {{ (isset($personal_information) && $personal_information->hospital ? $personal_information->hospital2_id : old('hospital2_id')) == $id ? 'selected' : '' }} data-country="{{$id}}">{{ $hospital2 }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Patient No">Hospital2 Patient No: 患者番号</label>
                    <input type="text" id="hospital2_patient_no" name="hospital2_patient_no" class="form-control" value="{{$personal_information->hospital2_patient_no}}">
                </div>
            </div>
            <div class="row">                    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Hospital">Hospital3  病院名 3:</label>
                        <select class="form-control select2" id="hospital3" name="hospital3_id" >
                            @foreach($hospitals as $id => $hospital3)
                                <option value="{{ $id }}" {{ (isset($personal_information) && $personal_information->hospital ? $personal_information->hospital3_id : old('hospital3_id')) == $id ? 'selected' : '' }} data-country="{{$id}}">{{ $hospital3 }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Patient No">Hospital3 Patient No: 患者番号</label>
                    <input type="text" id="hospital3_patient_no" name="hospital3_patient_no" class="form-control" value="{{$personal_information->hospital3_patient_no}}">
                </div>
            </div>

            <hr/>        
            <div class="row">
                <div class="col-md-6">
                    <label for="Disease">Chronic Disease 慢性疾患:</label>
                    <input type="text" id="medicals" name="medicals" class="form-control" value="{{$personal_information->medicals}}">
                    <!-- <select class="form-control select2" id="medical" name="medical_id" >
                        @foreach($medicals as $id => $medical)
                            <option value="{{ $id }}" {{ (isset($personal_information) && $personal_information->medical ? $personal_information->medical->id : old('medical_id')) == $id ? 'selected' : '' }}>{{ $medical }}</option>
                        @endforeach
                    </select> -->
                </div>                
            </div> 
            <br/>
            <div class="row">
                <div class="col-md-6">
                    <label for="Patient No">Past Medical Hystory 既往歴</label>
                    <textarea class="form-control" id="medical_hystory" name="medical_hystory" rows="2">{{$personal_information->medical_hystory}}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="Sympton">Comments 自由記入欄</label>
                    <textarea class="form-control" id="comments" name="comments" rows="2">{{$personal_information->comments}}</textarea>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('materials') ? 'has-error' : '' }}"  id="materials_div">
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
            <br/>

            <div class="row">
                <div class="col">
                    <a href="{{url()->previous()}}" class="btn btn-md btn-danger">Cancel</a>
                </div>
                <div class="col text-right">
                     <input class="btn btn-primary" type="submit" value="{{ trans('global.update') }}">
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
    @if(isset($user) && $user->materials)
              var files =
                {!! json_encode($user->materials) !!}
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
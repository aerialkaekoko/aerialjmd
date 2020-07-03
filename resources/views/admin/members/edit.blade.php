@extends('layouts.admin')
@section('styles')
    <style>
        .member-header{
            border-left: 3px solid #27AE60;
            padding-left: 10px;
        }
        h5{
            border-bottom: 1px solid #e3e3e3;
            padding-bottom: 10px;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')

<div class="card">
   
    <div class="card-header">
        
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.members.index') }}">Member Lists</a>
              </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">Edit Member</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.user-insurances.create",['user_id'=>$user->id,'type'=>'edit']) }}" id="user-insurance">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.insurance.title_singular') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.personal_informations.create',['user_id'=>$user->id,'type'=>'edit'])}}" id="personal-info">Personal Medical Informations</a>
                </li>
            </ul>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.members.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h5 class="mt-4"><span class="member-header">JMD Member</span></h5>
            <div class="row">
                <div class="col-md-6">
                    <label for="Member No">Member No.</label>
                    <p class="text-danger">{{$user->member_no}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                     <!-- Countries -->
                    <div class="form-group {{ $errors->has('desk') ? 'has-error' : '' }}">
                    <label for="desk">{{ trans('cruds.members.fields.desk') }}*</label>
                    <select id="desk" name="desk" class="form-control" required>
                        @foreach(trans('cruds.desk') as $key => $label)
                            <option value="{{ $key }}" {{ (isset($user) ? $user->desk : old('desk')) == $key ? 'selected' : '' }}>{{ $label }}
                            </option>
                        @endforeach
                    </select>
                        @if($errors->has('desk'))
                        <p class="help-block">
                            {{ $errors->first('desk') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.desk_helper') }}
                        </p>
                    </div> 
                    <!-- end Countries -->
                </div>
                <div class="col-md-6">
                     <!-- Countries -->
                    <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                    <label for="country">{{ trans('cruds.members.fields.country') }}*</label>
                    <select id="country" name="country" class="form-control" required>

                        @foreach(trans('cruds.countries') as $key => $label)
                            <option value="{{ $key }}" {{ (isset($user) ? $user->country : old('country')) == $key ? 'selected' : '' }}>{{ $label }}
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
                </div>
            </div>
            <h5 class="mt-4"><span class="member-header">Profile</span></h5>
            <div class="row">
                <div class="col-md-6">
                <!-- //family_name  -->
                    <div class="form-group {{ $errors->has('family_name') ? 'has-error' : '' }}">
                        <label for="family_name">{{ trans('cruds.members.fields.fname') }} 名 *</label>
                        <input type="text" id="family_name" name="family_name" class="form-control" value="{{ old('family_name', isset($user) ? $user->family_name : '') }}" required> 
                        @if($errors->has('family_name'))
                            <p class="help-block">
                                {{ $errors->first('family_name') }}
                            </p>
                        @endif
                            <p class="helper-block">
                                {{ trans('cruds.members.fields.fname_helper') }}
                            </p>
                    </div>
                <!-- end//family_name  -->
                </div>
                <div class="col-md-6">
                <!-- name -->
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.members.fields.name') }} 姓 *</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required> 
                        @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.name_helper') }}
                        </p>
                    </div>
                <!-- endname -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="dob">{{ trans('cruds.user.fields.dob') }} 生年月日</label>
                                
                                 <input type="text" class="form-control" name="dob" id="dob" value="{{ old('dob', isset($user) ? $user->dob : '') }}" placeholder="Enter DOB" autocomplete="off">
                                @if($errors->has('dob'))
                                <span class="text-danger">{{ $errors->first('dob') }}</span>
                                    @endif
                                <span class="help-block">{{ trans('cruds.user.fields.dob_helper') }}</span>
                            </div>  
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="age">{{ trans('cruds.members.fields.age') }} 年齢</label>
                                
                                 <input type="text" class="form-control" name="age" id="age" value="{{ old('age', isset($user) ? $user->age : '') }}" placeholder="Enter Age" autocomplete="off" readonly>
                                @if($errors->has('age'))
                                <span class="text-danger">{{ $errors->first('age') }}</span>
                                    @endif
                                <span class="help-block">{{ trans('cruds.members.fields.age_helper') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- gender -->
                    <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                    <label for="gender">{{ trans('cruds.members.fields.gender') }} 性別 *</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="" >{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\User::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ (isset($user) ? $user->gender : old('gender')) == (string)$key ? 'selected' : '' }}>{{ $label }}
                        </option>
                        @endforeach
                    </select>
                        @if($errors->has('gender'))
                        <p class="help-block">
                           {{ $errors->first('gender') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.gender_helper') }}
                        </p>
                    </div>
                    <!-- end gender -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- passport -->
                    <div class="form-group {{ $errors->has('passport') ? 'has-error' : '' }}">
                        <label for="passport">Passport No. パスポート番号</label>
                        <input type="text" id="passport" name="passport" class="form-control"
                            value="{{ old('passport', isset($user) ? $user->passport : '') }}">
                        @if($errors->has('passport'))
                        <p class="help-block">
                            {{ $errors->first('passport') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.passport_helper') }}
                        </p>
                    </div>
                    <!-- endpassport -->
                </div>
            </div>
            <h5 class="mt-4"><span class="member-header">Contact</span>  </h5>
            <div class="row">
                <div class="col-md-6">
                    <!-- email -->
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">{{ trans('cruds.members.fields.email') }}</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}"> @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.email_helper') }}
                        </p>
                    </div>
                    <!-- endemail -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- phone -->
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="phone">{{ trans('cruds.members.fields.phone') }} 現地電話番号</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($user) ? $user->phone : '') }}"> @if($errors->has('phone'))
                        <p class="help-block">
                            {{ $errors->first('phone') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.phone_helper') }}
                        </p>
                    </div>
                    <!--end phone -->
                </div>
                <div class="col-md-6">
                    <!-- phone -->
                    <div class="form-group {{ $errors->has('jpn_phone') ? 'has-error' : '' }}">
                        <label for="jpn_phone">{{ trans('cruds.members.fields.jpn_phone') }}日本国内電話番号</label>
                        <input type="text" id="jpn_phone" name="jpn_phone" class="form-control" value="{{ old('jpn_phone', isset($user) ? $user->jpn_phone : '') }}"> @if($errors->has('jpn_phone'))
                        <p class="help-block">
                            {{ $errors->first('jpn_phone') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.jpn_phone_helper') }}
                        </p>
                    </div>
                    <!--end phone -->
                </div>
            </div> 
            <div class="row">   
                <div class="col-md-6">
                    <!-- address_current -->
                    <div class="form-group {{ $errors->has('address_current') ? 'has-error' : '' }}">
                        <label for="address_current">{{ trans('cruds.members.fields.address_current') }} 現地住所</label>
                        <textarea id="address_current" name="address_current"
                            class="form-control">{{ old('address_current', isset($user) ? $user->address_current : '') }}</textarea>
                            @if($errors->has('address_current'))
                            <p class="help-block">
                                {{ $errors->first('address_current') }}
                            </p>
                            @endif
                            <p class="helper-block">
                            {{ trans('cruds.members.fields.address_current_helper') }}
                           </p>
                    </div>                                                    
                    <!-- end address -->
                </div>
                <div class="col-md-6">
                    <!-- address -->
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        <label for="address">{{ trans('cruds.members.fields.address') }} 日本国内住所</label>
                        <textarea id="address" name="address" class="form-control">{{ old('address', isset($user) ? $user->address : '') }}</textarea>
                        @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.address_helper') }}
                        </p>
                    </div>
                    <!-- end address -->
                </div>
            </div>
            <h5 class="mt-4"><span class="member-header">Place Of Employment</span></h5>
            
            <div class="row">
                 <div class="col-md-6">
                    <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                        <label for="company">{{ trans('cruds.members.fields.company') }} 会社名</label>
                        <input type="company" id="company" name="company" class="form-control" value="{{ old('company', isset($user) ? $user->company : '') }}" > @if($errors->has('company'))
                        <p class="help-block">
                            {{ $errors->first('company') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.company_helper') }}
                        </p>
                    </div>
                </div>
                  <div class="col-md-6">
                    <div class="form-group {{ $errors->has('emp_phone_no') ? 'has-error' : '' }}">
                        <label for="emp_phone_no">{{ trans('cruds.members.fields.emp_phone_no') }} 電話番号</label>
                        <input type="emp_phone_no" id="emp_phone_no" name="emp_phone_no" class="form-control" value="{{ old('emp_phone_no', isset($user) ? $user->emp_phone_no : '') }}" > @if($errors->has('emp_phone_no'))
                        <p class="help-block">
                            {{ $errors->first('emp_phone_no') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.emp_phone_no_helper') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                    <!-- address -->
                    <div class="form-group {{ $errors->has('emp_address') ? 'has-error' : '' }}">
                        <label for="emp_address">{{ trans('cruds.members.fields.emp_address') }} 住所</label>
                        <textarea id="emp_address" name="emp_address" class="form-control">{{ old('emp_address', isset($user) ? $user->emp_address : '') }}</textarea>
                        @if($errors->has('emp_address'))
                        <p class="help-block">
                            {{ $errors->first('emp_address') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.emp_address_helper') }}
                        </p>
                    </div>
                    <!-- end address -->
                </div>
            </div>
            <h5 class="mt-4"><span class="member-header">Attached File</span></h5>

            <div class="row">
                <div class="col-md-6">
                    <!-- passport info -->
                    <div class="form-group {{ $errors->has('passport_info') ? 'has-error' : '' }}">
                        <label for="passport_info">{{ trans('cruds.user.fields.passport_info') }}</label>
                        <div class="needsclick dropzone" id="passport_info-dropzone">
                    
                        </div>
                        @if($errors->has('passport_info'))
                        <p class="help-block">
                            {{ $errors->first('passport_info') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.passport_info_helper') }}
                        </p>
                    </div>
                    <!-- end passport info -->
                </div>
               
            </div>
            <!-- password -->
            <!-- <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">{{ trans('cruds.members.fields.password') }}</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @if($errors->has('password'))
                <p class="help-block">
                    {{ $errors->first('password') }}
                </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.members.fields.password_helper') }}
                </p>
            </div> -->   
            
            <div class="text-right">
                <input class="btn btn-info" type="submit" value="{{ trans('global.update') }}">
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#desk').on('click',function(){
            var desk_id = $(this).val();
            if(desk_id == 3){
                $('#country').val(3)
            }else if(desk_id == 4){
                $('#country').val(1)
            }else{
                $('#country').val(2)
            }
        })
        $('#dob').on('change',function(){
            var dob = $(this).val();
            var years = moment().diff(dob, 'years',false);
            $('#age').val(years);
        })
    })
    var uploadedPassportInfoMap = {}
Dropzone.options.passportInfoDropzone = {
    url: '{{ route('admin.members.storeMedia') }}',
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
      console.log('paoo',$('form').find('input[name="passport_info[]"]'))
    },
    init: function () {
@if(isset($user) && $user->passport_info)
          var files =
            {!! json_encode($user->passport_info) !!}
            console.log(files);
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
    var uploadedgrunteeMap = {}
Dropzone.options.grunteeDropzone = {
    url: '{{ route('admin.members.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="gruntee[]" value="' + response.name + '">')
      uploadedgrunteeMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedgrunteeMap[file.name]
      }
      $('form').find('input[name="gruntee[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($user) && $user->gruntee)
          var files =
            {!! json_encode($user->gruntee) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="gruntee[]" value="' + file.file_name + '">')
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
    url: '{{ route('admin.members.storeMedia') }}',
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
$('#dob').datepicker({
    dateFormat : 'yy-mm-dd',
    changeMonth : true,
    changeYear : true,
    yearRange: '-100:+0',
});
</script>
@stop
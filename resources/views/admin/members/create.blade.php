@extends('layouts.admin')
@section('styles')
    <style>
    /*form styles*/
#msform {
  width: 400px;
  margin: 10px auto;
  text-align: center;
  position: relative;
}

/*progressbar*/
#progressbar {
  overflow: hidden;
  /*CSS counters to number the steps*/
  counter-reset: step;
}

#progressbar li {
  list-style-type: none;
  text-transform: uppercase;
  font-size: 12px;
  width: 33.33%;
  float: left;
  position: relative;
}

#progressbar li:before {
  content: counter(step);
  counter-increment: step;
  width: 50px;
  line-height: 50px;
  display: block;
  font-size: 12px;
  color: #333;
  background: white;
  border: 1px solid #e3e3e3;
  border-radius: 50%;
  margin: 0 auto 5px auto;
}

/*progressbar connectors*/
#progressbar li:after {
  content: '';
  width: 60%;  /* Changed */
  height: 2px;
  background: #e3e3e3;
  position: absolute;
  left: -30%;  /* Changed */
  top: 25px;
  z-index: 1;  /* Changed */
}

#progressbar li:first-child:after {
  /*connector not needed before the first step*/
  content: none;
}

/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
  background: #27AE60;
  color: white;
}
.dz-size{
    display: none;
}
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
    <div class="row ">
        <div class="col progressbar">
            <form id="msform">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active">Member Register</li>
                    <li class="">User Insurance</li>
                    <li>Personal Medical</li>
                </ul>
            </form>
        </div>
    </div>
    <div class="card-body">
        <!-- member-create -->
        <form action="{{ route("admin.register1") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h5 class=""><span class="member-header">JMD Member</span></h5>
            
            <div class="row">
                <div class="col-md-6">
                     <!-- Countries -->
                    <div class="form-group {{ $errors->has('desk') ? 'has-error' : '' }}">
                    <label for="desk">{{ trans('cruds.members.fields.desk') }}*</label>
                    <select id="desk" name="desk" class="form-control">
                        @foreach(trans('cruds.desk') as $key => $label)
                            @php
                                $current_desk = (auth()->user()->country == 1) ? 4 : (auth()->user()->country == 2 ? 1 : 3 ) ;
                            @endphp
                            <option value="{{ $key }}" {{ (isset($user) ? $user->desk : old('desk')) == $key ? 'selected' : ($current_desk == $key ?'selected':'') }}>{{ $label }}
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
                            <option value="{{ $key }}" {{ ( old('country')??2) == $key ? 'selected' : '' }}>{{ $label }}
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
                        <input type="text" id="passport" name="passport" class="form-control" value="{{ old('passport', isset($user) ? $user->passport : '') }}"> 
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
                        <label for="jpn_phone">{{ trans('cruds.members.fields.jpn_phone') }} 日本国内電話番号</label>
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
                        <textarea id="emp_address" name="emp_address" class="form-control" >{{ old('emp_address', isset($user) ? $user->emp_address : '') }}</textarea>
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
            <div class="row" style="margin:0 1em 2em;">
                <div class="col-md-6 ">
                    @if (Request::get('type') == 'create')
                        <a href="{{route('admin.members.old_medical_info',['user_id'=>$user_id])}}" class="btn btn-md btn-success">Skip</a>
                    @else
                        <a href="{{ URL::previous() }}" class="btn btn-md btn-danger">Cancel</a>
                    @endif
                </div>
                <div class="col-md-6 text-right">
                    <input class="btn btn-primary" type="submit" value="Continue">
                </div>
            </div>
            
        </form>
    </div>
</div>            
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#desk').change(function(){
            $(this).find("option:selected").each(function(){
                var desk_id = $(this).val();
                if(desk_id == 3){
                    $('#country').val(3)
                }else if(desk_id == 4){
                    $('#country').val(1)
                }else{
                    $('#country').val(2)
                }
                
            });
        }).change();
        $('#dob').on('change',function(){
            var dob = $(this).val();
            var years = moment().diff(dob, 'years',false);
            $('#age').val(years);
        })
        
    })
    var uploadedPassportInfoMap = {}
Dropzone.options.passportInfoDropzone = {
    url: '{{ route('admin.register.storeMedia') }}',
    maxFilesize: 5, // MB
    maxFiles: 1,
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

      $('form').find('input[name="passport_info[]"][value="' + file.name + '"]').remove()
    },
    init: function () {
    // console.log('passport',{!! json_encode($passport_info) !!})
@if(isset($passport_info))
          // var image_path="{{URL::asset('storage/tmp/uploads/')}}/";
          // console.log('path',image_path);
          var files =
            {!! json_encode($passport_info) !!}
              for (var i in files) {
              var file = {'name' : files[i]}
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="passport_info[]" value="' + file.name + '">')
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
    url: '{{ route('admin.register.storeMedia') }}',
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
        console.log(response)
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
      $('form').find('input[name="insurance[]"][value="' + file.name + '"]').remove()
    },
    init: function () {
@if(isset($insurance))
          var files =
            {!! json_encode($insurance) !!}
            console.log('insu',files);
              for (var i in files) {
              var file = {'name' : files[i]}
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="insurance[]" value="' + file.name + '">')
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
    dateFormat  : 'yy-mm-dd',
    changeMonth : true,
    changeYear  : true,
    // yearRange: '1950:2020',
    yearRange: '-100:+0',
});
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
@stop
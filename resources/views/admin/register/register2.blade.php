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
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                 <div class="row ">
                    <div class="col progressbar">
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="">Member Register</li>
                                <li class="active">User Insurance</li>
                                <li>Personal Medical</li>
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route("admin.register2") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                <label for="user">Member</label>
                                <p class="text-danger">{{$user->family_name}} {{$user->name}}</p>
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                @if($errors->has('user_id'))
                                    <p class="help-block">
                                        {{ $errors->first('user_id') }}
                                    </p>
                                @endif
                            </div>
                          </div>
                          <div class="col-md-8">
                            <!-- type -->
                            <label for="type">Type 種別</label>
                                <div class="row">
                                    @foreach(App\UserInsurance::TYPE as $key => $label)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1" data-key="{{$key}}" value="{{$key}}" name="type[]" {{isset($userInsurance) && in_array($key,unserialize($userInsurance->type))?'checked':''}}>
                                                <label class="form-check-label" for="exampleCheck1">{{$label}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if($errors->has('type'))
                                    <p class="help-block text-danger">
                                        {{ $errors->first('type') }}
                                    </p>
                                @endif
                            <!-- end type -->
                          </div>
                        </div>
                        <div class="box type-div1">
                          <h5 class="mt-4"><span class="member-header">OTAI 1 任意保険 1</span></h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group {{ $errors->has('insurance_id') ? 'has-error' : '' }}">
                                      <label for="insurance">Insurance Company 保険会社</label>
                                      <select name="insurance_id1" id="insurance1" class="form-control select2" >
                                          @foreach($insurances as $id => $insurance)
                                              <option value="{{ $id }}" {{ (isset($userInsurance)? $userInsurance->insurance_id1 : old('insurance_id1')) == $id ? 'selected' : '' }}>{{ $insurance }}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has('insurance_id1'))
                                          <p class="help-block">
                                              {{ $errors->first('insurance_id1') }}
                                          </p>
                                      @endif
                                  </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group {{ $errors->has('assistance_id1') ? 'has-error' : '' }}">
                                      <label for="assistance">Assistance Company アシスタンス会社名</label>
                                      <select name="assistance_id1" id="assistance1" class="form-control select2" >
                                          @foreach($assistances as $id => $assistance)
                                              <option value="{{ $id }}" {{ (isset($userInsurance)? $userInsurance->assistance_id1 : old('assistance_id1')) == $id ? 'selected' : '' }}>{{ $assistance }}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has('assistance_id1'))
                                          <p class="help-block">
                                              {{ $errors->first('assistance_id1') }}
                                          </p>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">                
                                  <div class="form-group {{ $errors->has('policy_number1') ? 'has-error' : '' }}">
                                      <label for="policy_number1">{{ trans('cruds.user.fields.policy_number') }} 証券番号</label>
                                      <input type="text" id="policy_number1" name="policy_number1" class="form-control" value="{{ old('policy_number1', isset($userInsurance) ? $userInsurance->policy_number1 : '') }}" >
                                      @if($errors->has('policy_number1'))
                                          <p class="help-block">
                                              {{ $errors->first('policy_number1') }}
                                          </p>
                                      @endif
                                      <p class="helper-block">
                                          {{ trans('cruds.user.fields.policy_number_helper') }}
                                      </p>
                                  </div>                
                              </div>

                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="Invoice Code">Policy Period 保険期間 => From:</label>
                                      <input type="text" class="form-control" name="policy_period_from1" id="policy_period_from1" value="{{ old('policy_period_from1', isset($userInsurance) ? $userInsurance->policy_period_from1 : '') }}" placeholder="From Date" autocomplete="off">
                                      <span class="error_policy_period_from1 text-danger"></span>
                                  </div>
                              </div>    
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="Invoice Code">To:</label>
                                      <input type="text" class="form-control" name="policy_period_to1" id="policy_period_to1" value="{{ old('policy_period_to1', isset($userInsurance) ? $userInsurance->policy_period_to1 : '') }}" placeholder="To Date" autocomplete="off">
                                      <span class="error_policy_period_to1 text-danger"></span>
                                  </div>
                              </div>                    
                          </div>
                          <h5 class="mt-4"><span class="member-header">OTAI 2 保険会社 2</span></h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group {{ $errors->has('insurance_id2') ? 'has-error' : '' }}">
                                      <label for="insurance">Insurance Company 保険会社</label>
                                      <select name="insurance_id2" id="template" class="form-control select2" >
                                          @foreach($insurances as $id => $insurance)
                                              <option value="{{ $id }}" {{ (isset($userInsurance)? $userInsurance->insurance_id2 : old('insurance_id2')) == $id ? 'selected' : '' }}>{{ $insurance }}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has('insurance_id2'))
                                          <p class="help-block">
                                              {{ $errors->first('insurance_id2') }}
                                          </p>
                                      @endif
                                  </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group {{ $errors->has('assistance_id2') ? 'has-error' : '' }}">
                                      <label for="assistance">Assistance Company アシスタンス会社名</label>
                                      <select name="assistance_id2" id="assistance2" class="form-control select2" >
                                          @foreach($assistances as $id => $assistance)
                                              <option value="{{ $id }}" {{ (isset($userInsurance)? $userInsurance->assistance_id2 : old('assistance_id2')) == $id ? 'selected' : '' }}>{{ $assistance }}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has('assistance_id2'))
                                          <p class="help-block">
                                              {{ $errors->first('assistance_id2') }}
                                          </p>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">                
                                  <div class="form-group {{ $errors->has('policy_number2') ? 'has-error' : '' }}">
                                      <label for="policy_number2">{{ trans('cruds.user.fields.policy_number') }} 証券番号</label>
                                      <input type="text" id="policy_number2" name="policy_number2" class="form-control" value="{{ old('policy_number2', isset($userInsurance) ? $userInsurance->policy_number2 : '') }}" >
                                      @if($errors->has('policy_number2'))
                                          <p class="help-block">
                                              {{ $errors->first('policy_number2') }}
                                          </p>
                                      @endif
                                      <p class="helper-block">
                                          {{ trans('cruds.user.fields.policy_number_helper') }}
                                      </p>
                                  </div>                
                              </div>

                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="Invoice Code">Policy Period 保険期間 => From:</label>
                                      <input type="text" class="form-control" name="policy_period_from2" id="policy_period_from2" value="{{ old('policy_period_from2', isset($userInsurance) ? $userInsurance->policy_period_from2 : '') }}" placeholder="From Date" autocomplete="off">
                                      <span class="error_policy_period_from2 text-danger"></span>
                                  </div>
                              </div>    
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="Invoice Code">To:</label>
                                      <input type="text" class="form-control" name="policy_period_to2" id="policy_period_to2" value="{{ old('policy_period_to2', isset($userInsurance) ? $userInsurance->policy_period_to2 : '') }}" placeholder="To Date" autocomplete="off">
                                      <span class="error_policy_period_to2 text-danger"></span>
                                  </div>
                              </div>                    
                          </div>
                        </div>
                        <div class="box type-div2">
                          <h5 class="mt-4"><span class="member-header">Membership Info メンバーシップ</span></h5>
                          <div class="row">
                            <div class="col-md-6">
                                  <div class="form-group {{ $errors->has('membership_id') ? 'has-error' : '' }}">
                                      <label for="Membership">Membership Company 会社名</label>
                                      <select name="membership_id" id="membership" class="form-control select2">
                                          @foreach($memberships as $id => $membership)
                                              <option value="{{ $id }}" {{ (isset($userInsurance)? $userInsurance->membership_id : old('membership_id')) == $id ? 'selected' : '' }}>{{ $membership }}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has('membership_id'))
                                          <p class="help-block">
                                              {{ $errors->first('membership_id') }}
                                          </p>
                                      @endif
                                  </div>
                              </div>
                              <div class="col-md-6">                
                                  <div class="form-group {{ $errors->has('member_no') ? 'has-error' : '' }}">
                                      <label for="member_no">Member No. 会員番号</label>
                                      <input type="text" id="member_no" name="member_no" class="form-control" value="{{ old('member_no', isset($userInsurance) ? $userInsurance->member_no : '') }}" placeholder="Enter Member No..">
                                      @if($errors->has('member_no'))
                                          <p class="help-block">
                                              {{ $errors->first('member_no') }}
                                          </p>
                                      @endif
                                  </div>                
                              </div>
                          </div>
                        </div>
                        <div class="box type-div3">
                          <h5 class="mt-4"><span class="member-header">Credit Card Info クレジットカード</span></h5>
                          <div class="row">
                            <div class="col-md-6">                
                                  <div class="form-group {{ $errors->has('credit_type') ? 'has-error' : '' }}">
                                      <label for="credit_type">Credit Type</label>
                                      <input type="text" id="credit_type" name="credit_type" class="form-control" value="{{ old('credit_type', isset($userInsurance) ? $userInsurance->credit_type : '') }}" placeholder="Enter Credit Type">
                                      @if($errors->has('credit_type'))
                                          <p class="help-block">
                                              {{ $errors->first('credit_type') }}
                                          </p>
                                      @endif
                                  </div>                
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group {{ $errors->has('credit_insurance_company') ? 'has-error' : '' }}">
                                      <label for="insurance">Insurance Company 引受保険会社</label>
                                      <select name="credit_insurance_company" id="credit_insurance_company" class="form-control select2">
                                          @foreach($insurances as $id => $insurance)
                                              <option value="{{ $id }}" {{ (isset($userInsurance)? $userInsurance->credit_insurance_company : old('credit_insurance_company')) == $id ? 'selected' : '' }}>{{ $insurance }}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has('credit_insurance_company'))
                                          <p class="help-block">
                                              {{ $errors->first('credit_insurance_company') }}
                                          </p>
                                      @endif
                                  </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group {{ $errors->has('credit_assistance_company') ? 'has-error' : '' }}">
                                      <label for="assistance">Assistance Company アシスタンス会社名</label>
                                      <select name="credit_assistance_company" id="credit_assistance_company" class="form-control select2">
                                          @foreach($assistances as $id => $assistance)
                                              <option value="{{ $id }}" {{ (isset($userInsurance)? $userInsurance->credit_assistance_company : old('credit_assistance_company')) == $id ? 'selected' : '' }}>{{ $assistance }}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has('credit_assistance_company'))
                                          <p class="help-block">
                                              {{ $errors->first('credit_assistance_company') }}
                                          </p>
                                      @endif
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="box type-div4 ">
                          <h5 class="mt-4"><span class="member-header">Other Type　そのほか</span></h5>
                          <div class="row">
                            <div class="col-md-6">
                              <!-- type -->
                              <div class="form-group {{ $errors->has('other_type') ? 'has-error' : '' }}">
                                 <label for="other_type">Other Type</label>
                                <select id="other_type" name="other_type" class="form-control">
                                        @foreach(App\UserInsurance::OTHER_TYPE as $key => $label)
                                        <option value="{{ $key }}" {{ (isset($userInsurance) ? $userInsurance->other_type : old('other_type')) == (string)$key ? 'selected' : '' }}>{{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('other_type'))
                                    <p class="help-block">
                                        {{ $errors->first('other_type') }}
                                    </p>
                                    @endif
                                </div>
                                <!-- end type -->
                            </div>
                            <div class="col-md-6 otherdiv1 box2">
                                <div class="form-group {{ $errors->has('cash_comment') ? 'has-error' : '' }}">
                                    <label for="Cash Comment">Cash Comments</label>
                                    <textarea id="cash_comments" name="cash_comments" rows="3" class="form-control" placeholder="Enter Comments">{{ old('cash_comments', isset($userInsurance) ? $userInsurance->cash_comments : '') }}</textarea>
                                    @if($errors->has('cash_comments'))
                                        <p class="help-block">
                                            {{ $errors->first('cash_comments') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 otherdiv2 box2">
                                <div class="form-group {{ $errors->has('cash_comment') ? 'has-error' : '' }}">
                                    <label for="Corporate Company">Corporate Company</label>
                                    <input type="text" id="corporate_company" name="corporate_company" class="form-control" value="{{ old('corporate_company', isset($userInsurance) ? $userInsurance->corporate_company : '') }}" placeholder="Enter Company">
                                    @if($errors->has('corporate_company'))
                                        <p class="help-block">
                                            {{ $errors->first('corporate_company') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                             <div class="col-md-6 otherdiv3 box2">
                                  <div class="form-group {{ $errors->has('local_insurance_id') ? 'has-error' : '' }}">
                                      <label for="Membership">Local Insurance Company</label>
                                      <select name="local_insurance_id" id="local_insurance_id" class="form-control select2">
                                          @foreach($localInsurances as $id => $localInsurance)
                                              <option value="{{ $id }}" {{ (isset($userInsurance)? $userInsurance->local_insurance_id : old('local_insurance_id')) == $id ? 'selected' : '' }}>{{ $localInsurance }}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has('local_insurance_id'))
                                          <p class="help-block">
                                              {{ $errors->first('local_insurance_id') }}
                                          </p>
                                      @endif
                                  </div>
                              </div>
                              <div class="col-md-6 otherdiv5 box2">
                                <div class="form-group {{ $errors->has('other_comment') ? 'has-error' : '' }}">
                                    <label for="Other Comment">Other Comments</label>
                                    <textarea id="other_comments" name="other_comments" rows="3" class="form-control" placeholder="Enter Comments">{{ old('other_comments', isset($userInsurance) ? $userInsurance->other_comments : '') }}</textarea>
                                    @if($errors->has('other_comments'))
                                        <p class="help-block">
                                            {{ $errors->first('other_comments') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                          </div>
                        </div>
                        <h5 class="mt-4"><span class="member-header">Attached File 添付</span></h5>
                        <div class="row">
                          <div class="col-md-6">
                              <!-- passport info -->
                              <div class="form-group {{ $errors->has('insurance') ? 'has-error' : '' }}">
                                  <label for="insurance">{{ trans('cruds.user.fields.insurance') }}</label>
                                  <div class="needsclick dropzone" id="insurance-dropzone">
                                  </div>
                                  @if($errors->has('insurance'))
                                      <p class="help-block">
                                          {{ $errors->first('insurance') }}
                                      </p>
                                  @endif
                                      <p class="helper-block">
                                          {{ trans('cruds.members.fields.insurance_helper') }}
                                      </p>
                               </div>
                              <!-- end passport info -->
                          </div>
                          <div class="col-md-6">
                              <div class="form-group {{ $errors->has('template') ? 'has-error' : '' }}">
                                  <label for="insurance">Insurance Info 2</label>
                                  <div class="needsclick dropzone" id="template-dropzone">
                                  </div>
                                  @if($errors->has('template'))
                                      <p class="help-block">
                                          {{ $errors->first('template') }}
                                      </p>
                                  @endif
                                      <p class="helper-block">
                                          {{ trans('cruds.members.fields.insurance_helper') }}
                                      </p>
                               </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('admin.register3')}}" class="btn btn-default">Skip</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('admin.register1')}}" class="btn btn-warning">Back To Member Register</a>
                                <input class="btn btn-info" type="submit" value="Continue">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.form-check-input').each(function(){
                var key = $(this).data('key');
                if (this.checked) {
                    $(".type-div" + key).show();
                } else {
                    $(".type-div" + key).hide();
                }

            });
            $(".form-check-input").click(function(){
                var key = $(this).data('key');
                if (this.checked) {
                    $(".type-div" + key).show();
                } else {
                    $(".type-div" + key).hide();
                }

            });
        
           $("#other_type").change(function(){
                $(this).find("option:selected").each(function(){
                    var optionValue = $(this).attr("value");
                    if(optionValue){

                    $(".box2").not(".otherdiv" + optionValue).hide();

                    $(".otherdiv" + optionValue).show();

                    } else{

                    $(".box2").hide();

                    }
                });
            }).change();
            var policy_period_from1;
            var policy_period_to1;
            $('#policy_period_from1').datepicker({
                dateFormat : 'yy-mm-dd',
            });
            $('#policy_period_to1').datepicker({
                dateFormat : 'yy-mm-dd',
            });
            $('#policy_period_from1').change(function() {
              policy_period_from1 = $(this).datepicker('getDate');
              $("#policy_period_to1").datepicker("option", "minDate", policy_period_from1 );
            });
            $('#policy_period_to1').change(function() {
              policy_period_to1 = $(this).datepicker('getDate');
              $("#policy_period_from1").datepicker("option", "maxDate", policy_period_to1 );
            });

            var policy_period_from2;
            var policy_period_to2;
            $('#policy_period_from2').datepicker({
                dateFormat : 'yy-mm-dd',
            });
            $('#policy_period_to2').datepicker({
                dateFormat : 'yy-mm-dd',
            });
            $('#policy_period_from2').change(function() {
              policy_period_from2 = $(this).datepicker('getDate');
              $("#policy_period_to2").datepicker("option", "minDate", policy_period_from2 );
            });
            $('#policy_period_to2').change(function() {
              policy_period_to2 = $(this).datepicker('getDate');
              $("#policy_period_from2").datepicker("option", "maxDate", policy_period_to2 );
            });
        });
    </script>
    <script>
    var uploadedinsuranceMap = {}
Dropzone.options.insuranceDropzone = {
    url: '{{ route('admin.register.storeMedia') }}',
    maxFilesize: 6, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 6
    },
    success: function (file, response) {
    console.log('response',response)
      $('form').append('<input type="hidden" name="insurance[]" value="' + response.name + '">')
      uploadedinsuranceMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedinsuranceMap[file.name]
      }
      $('form').find('input[name="insurance[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($userInsurance) && $userInsurance->insurance)
          var files =
            {!! json_encode($userInsurance->insurance) !!}
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
<script>
    var uploadedtemplateMap = {}
Dropzone.options.templateDropzone = {
    url: '{{ route('admin.register.storeMedia') }}',
    maxFilesize: 6, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 6
    },
    success: function (file, response) {
    console.log('response',response)
      $('form').append('<input type="hidden" name="template[]" value="' + response.name + '">')
      uploadedtemplateMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedtemplateMap[file.name]
      }
      $('form').find('input[name="template[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($userInsurance) && $userInsurance->template)
          var files =
            {!! json_encode($userInsurance->template) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="template[]" value="' + file.file_name + '">')
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
@endsection

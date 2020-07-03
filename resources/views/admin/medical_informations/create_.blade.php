@extends('layouts.admin')
@section('content')
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12" style="text-align: right;margin: 0 -9px;"> 
        @php
            $exchange = App\Exchange::all()->last();
        @endphp
        <input type="text" name="" id="thb" value="{{$exchange->exchange_thb}}">
        <input type="text" name="" id="lak" value="{{$exchange->exchange_lak}}">
        <input type="text" name="" id="mmk" value="{{$exchange->exchange_mmk}}">
        <span><b>Exchange Rate</b><i class="fas fa-exchange-alt text-danger" style="padding: 0 5px;font-weight: 600;"></i> THB => {{$exchange->exchange_thb}} ,LAK => {{$exchange->exchange_lak}} , MMK => {{$exchange->exchange_mmk}}</span>
        @can('exchanges_edit')
            <a class="btn btn-xs btn-warning" href="{{ route('admin.exchanges.edit', $exchange->id) }}?medical_exchange=1&user_id={{$user->id}}" data-toggle="tooltip" data-placement="top" title="Edit Currency">
                <i class="fas fa-edit"></i>
            </a>
        @endcan
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{-- {{ trans('global.create') }} {{ trans('cruds.medical_informations.title_singular') }} --}}
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
                <a class="nav-link " href="{{ route('admin.members.index') }}">Member Lists</a>
          </li>
            <li class="nav-item">
                 <a class="nav-link " href="{{ route('admin.members.edit', $user->id) }}">Edit Member</a>
            </li>
           <li class="nav-item">
                <a class="nav-link" href="{{route('admin.user-insurances.index',['user_id'=>$user->id])}}" id="user-insurance">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.insurance.title_singular') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Add Medical Info</a>
            </li>
            
        </ul>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.medical_informations.store",['user_id'=>$user->id]) }}" method="POST" class="checkExchange" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ Request::get('type') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="User">Patient *:</label>
                                <p class="text-danger">{{$user->name}} {{$user->family_name}}</p>
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('treatment_date') ? 'has-error' : '' }}">
                                <label for="title">Treatment Date *:</label>
                                <input type="text" id="treatment_date" name="treatment_date" class="form-control" value="{{ old('treatment_date', isset($medical_information) ? $medical_information->treatment_date : '') }}" placeholder="Treatment Date" autocomplete="off" required="">
                                @if($errors->has('treatment_date'))
                                    <p class="help-block">
                                        {{ $errors->first('treatment_date') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Hospital">Hospital *:</label>
                        <select class="form-control select2" id="hospital" name="hospital_id" required="">
                            <option value="" data-country="">Please Select</option>
                            @foreach($hospitals as $id => $hospital)
                                <option value="{{ $hospital->id }}" data-country="{{$hospital->country}}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                   <div class="row">
                       <div class="col-md-6">
                            <label for="Disease">Disease *:</label>
                            <select class="form-control select2" id="medical" name="medical_id" required="">
                                @foreach($medicals as $id => $medical)
                                    <option value="{{ $id }}" {{ (Request::get('disease_id') == $id) ? 'selected' : '' }}>{{ $medical }}</option>
                                @endforeach
                            </select>
                       </div>
                        <div class="col-md-6">
                            <label for="Disease">Treatment :</label>
                            <select class="form-control" id="finish" name="finish" >
                                <option value="0">Pending</option>
                                <option value="1">Finish</option>
                            </select>
                       </div>
                   </div>
                </div>
                 <div class="col-md-6">
                    <label for="Agt Ref No">Agt Ref No :</label>
                    <input type="text" id="agt_ref_no" name="agt_ref_no" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('appointment_date') ? 'has-error' : '' }}">
                        <label for="title">Appointment Date:</label>
                        <input type="text" id="appointment_date" name="appointment_date" class="form-control" value="{{ old('appointment_date', isset($medical_information) ? $medical_information->appointment_date : '') }}" placeholder="Appointment Date" autocomplete="off">
                            @if($errors->has('appointment_date'))
                                <p class="help-block">
                                    {{ $errors->first('appointment_date') }}
                                </p>
                            @endif
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>

            <div class="row payment-type">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Payment Type">Payment Type *:</label>
                        <select class="form-control" name="receive_type" id="receive_type" required="">
                            <option value="">Choose Payment Type</option>
                            <option value="1">Insurance</option>
                            <option value="2">Cash</option>
                            <option value="3">Membership</option>
                            <option value="4">CreditCard</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 byCardNo">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Insurance">Card No.</label>
                                <input type="text" id="card_no" name="card_no" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 byInsurance">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Insurance">Insurance:</label>
                                <select class="form-control select2" name="insurance_id" id="insurance">
                                    @foreach ($user_insurances as $id=>$insurance)
                                        <option value="{{ $id }}" >{{ $insurance }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Assistance">Assistance :</label>
                                <select class="form-control select2" name="assistance_id" id="assistance">
                                    <option value="">Choose</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('medical_amount') ? 'has-error' : '' }}">
                        <label for="medical_amount">{{ trans('cruds.medical_informations.fields.medical_amount') }}*</label>
                        <input type="text" id="medical_amount" name="medical_amount" class="form-control text-right" onkeypress="return isNumberKey(event)" value="" required="">
                        @if($errors->has('medical_amount'))
                            <p class="help-block">
                                {{ $errors->first('medical_amount') }}
                            </p>
                        @endif
                    </div>
                </div>                
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('other_fee') ? 'has-error' : '' }}">
                        <label for="other_fee">{{ trans('cruds.medical_informations.fields.other_fee') }}</label>
                        <input type="text" id="other_fee" name="other_fee" class="form-control text-right" onkeypress="return isNumberKey(event)" value="0">
                        @if($errors->has('other_fee'))
                            <p class="help-block">
                                {{ $errors->first('other_fee') }}
                            </p>
                        @endif
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('document_date') ? 'has-error' : '' }}">
                        <label for="title">Document to BA Office:</label>
                        <input type="text" id="document_date" name="document_date" class="form-control" value="{{ old('document_date', isset($medical_information) ? $medical_information->document_date : '') }}" placeholder="Document to Office Date">
                            @if($errors->has('document_date'))
                               <p class="help-block">
                                    {{ $errors->first('document_date') }}
                                </p>
                            @endif
                    </div>
                </div> 
                <div class="col-md-6">               
                    <div class="form-group {{ $errors->has('insentive') ? 'has-error' : '' }}">
                        <label for="insentive">{{ trans('cruds.medical_informations.fields.insentive') }}</label>
                        <input type="text" id="insentive" name="insentive" class="form-control" value=""> 
                    </div>
                </div>
            </div>

            <div class="row">
                 <div class="col-md-6">
                    <label for="Side Response">Side Response *:</label>
                    <select class="form-control" name="side_response" id="side_response" required="">
                            <option value="">Choose</option>
                            <option value="1">Phone</option>
                            <option value="2">Person</option>
                        </select>
                </div>
                <div class="col-md-6">
                    <label for="Translator Name">Translator Name :</label>
                    <input type="text" id="translator_name" name="translator_name" class="form-control">
                </div>
            </div>                        
              
            <div class="row ipd-opd">
                <div class="col-md-6">
                    <div class="form-group" id="ipd_div">
                        <label for="Patient Type">IPD/OPD</label>
                        <select class="form-control" name="patient_type" id="patient_type" >
                            <option value="">Choose Type</option>
                            <option value="1">IPD</option>
                            <option value="2">OPD</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row" id="ipd_date">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Start Date">Start Date</label>
                                <input type="text" class="form-control" name="ipd_start_date" id="ipd_start_date" placeholder="Enter Start Date" autocomplete="off">
                                <span class="error_ipd_start_date text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Finish Date">Finish Date</label>
                                <input type="text" class="form-control" name="ipd_finish_date" id="ipd_finish_date" placeholder="Enter Finish Date" autocomplete="off">
                                <span class="error_ipd_finish_date text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            
            <div class="row service-time">
                <div class="col-md-6">
                    <label for="Service Time">Service Time:</label>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="From"> From </label>
                            <input type="time" id="service_time" name="service_time" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="To">To</label>
                            <input type="time" id="service_outtime" name="service_outtime" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Sympton">Sympton :</label>
                    <textarea class="form-control" id="sympton" name="sympton" rows="2"></textarea>
                </div>
            </div>
            <div class="row">                
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('medicalinvoice') ? 'has-error' : '' }}" id="medicalinvoice_div">
                        <label for="medicalinvoice">Medical Invoice</label>
                        <div class="needsclick dropzone" id="medicalinvoice-dropzone">
                        </div>
                        @if($errors->has('medicalinvoice'))
                        <p class="help-block">
                            {{ $errors->first('medicalinvoice') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            medical invoice
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Sympton">Remark :</label>
                    <textarea class="form-control" id="remark" name="remark" rows="2"></textarea>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('gruntee') ? 'has-error' : '' }}" id="gruntee_div">
                        <label for="gruntee">{{ trans('cruds.user.fields.gruntee') }}</label>
                        <div class="needsclick dropzone" id="gruntee-dropzone">
                        </div>
                        @if($errors->has('gruntee'))
                        <p class="help-block">
                            {{ $errors->first('gruntee') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.gruntee_helper') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('medicalinfoform') ? 'has-error' : '' }}" id="medicalinfoform_div">
                        <label for="medicalinfoform">{{ trans('cruds.user.fields.medicalinfoform') }}</label>
                        <div class="needsclick dropzone" id="medicalinfoform-dropzone">
                        </div>
                        @if($errors->has('medicalinfoform'))
                        <p class="help-block">
                            {{ $errors->first('medicalinfoform') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.medicalinfoform_helper') }}
                        </p>
                    </div>
                </div>
            </div>

            <hr/>
            <div class="row" id="currency_thb" style="display: none;">
                <div class="col-md-12">
                   <h4>Currency Exchange Rate</h4>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('exchange_thb') ? 'has-error' : '' }}">
                        <label for="exchange_thb">Thai Baht</label>
                        <input type="number" id="exchange_thb" name="exchange_thb" class="form-control text-right" value="{{ App\Exchange::latest()->first()->exchange_thb }}" readonly="">
                        @if($errors->has('exchange_thb'))
                            <p class="help-block">
                                {{ $errors->first('exchange_thb') }}
                            </p>
                        @endif
                    </div>                   
                </div>
            </div>
            <div class="row" id="currency_lak" style="display: none;">
                <div class="col-md-12">
                   <h4>Currency Exchange Rate</h4>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('exchange_lak') ? 'has-error' : '' }}">
                        <label for="exchange_lak">Laos Kip</label>
                        <input type="number" id="exchange_lak" name="exchange_lak" class="form-control text-right" value="{{ App\Exchange::latest()->first()->exchange_lak }}" readonly="">
                        @if($errors->has('exchange_lak'))
                            <p class="help-block">
                                {{ $errors->first('exchange_lak') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row" id="currency_mmk" style="display: none;">
                <div class="col-md-12">
                   <h4>Currency Exchange Rate</h4>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('exchange_mmk') ? 'has-error' : '' }}">
                        <label for="exchange_mmk">Burmese Kyat</label>
                        <input type="number" id="exchange_mmk" name="exchange_mmk" class="form-control text-right" value="{{ App\Exchange::latest()->first()->exchange_mmk }}" readonly="">
                        @if($errors->has('exchange_mmk'))
                            <p class="help-block">
                                {{ $errors->first('exchange_mmk') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <input type="hidden" id="assistance_store_id" value="">
            <div class="row">                
                <div class="col-md-6">
                        <a href="{{ URL::previous() }}" class="btn btn-md btn-danger">Cancel</a>
                </div>
                <div class="col-md-6 text-right">
                    <input class="btn btn-primary" type="submit" value="{{ trans('global.save') }}">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/jquery-repeater.js')}}"></script>
    <script>
        $(document).ready(function(){
        $('.checkExchange').on('submit',function () {
            var country_code = $('#hospital').find(':selected').data('country');
            if (country_code) {
                var exchange_amount = 0;
                if (country_code == 1) {
                    exchange_amount = $('#mmk').val();
                }else if(country_code == 2){
                    exchange_amount = $('#thb').val();
                }else{
                    exchange_amount = $('#lak').val();
                }
                if (exchange_amount == 0) {
                    alert('Your Exchange Amount is 0.Please Update Currency');
                    return false;
                }
            }else{ alert('Please Select Hospital');return false;}
            
        });
        var disease_id = {{Request::get('disease_id')??0}};
        if (disease_id != 0) {
            var patient_id = {{$user->id}};
            var disease_id = disease_id;
            getOngoingData(patient_id,disease_id);
        }
        $('#hospital').on('change',function(){
            if ($(this).find(':selected').data('country') == 1) {              
                $('#ipd_div').hide(); 
            } else {
                $('#ipd_div').show();                
            }
        });
        $('#treatment_date').datepicker({
            dateFormat : 'yy-mm-dd',
        });
        $('#appointment_date').datepicker({
            dateFormat : 'yy-mm-dd',
        });
        $('#document_date').datepicker({
            dateFormat : 'yy-mm-dd',
        });
        $('.byInsurance').hide();
        $('.byCardNo').hide();
        $('#gruntee_div').hide();
        $('#ipd_div').hide();
        $('#medicalinfoform_div').hide();
        $('#receive_type').on('change',function(){
            if ($(this).val() == 1) {
                $('.byInsurance').show();
                $('.byCardNo').hide();
                $('#assistance').attr('required',false);
                $('#insurance').attr('required',true);
                $('#other_fee').attr('readonly',false);
                $('#gruntee_div').show();
                $('#medicalinfoform_div').show();
            }else if($(this).val() == 4) {
                $('.byInsurance').hide();
                $('.byCardNo').show();
                $('#assistance').attr('required',false);
                $('#insurance').attr('required',false);
                $('#other_fee').attr('readonly',true);
                $('#gruntee_div').hide();
                $('#medicalinfoform_div').hide();
            }else{
                $('.byInsurance').hide();
                $('.byCardNo').hide();
                $('#assistance').attr('required',false);
                $('#insurance').attr('required',false);
                $('#other_fee').attr('readonly',true);
                $('#gruntee_div').hide();
                $('#medicalinfoform_div').hide();
            }
        });
        $('#patient_type').on('change',function(){
            if ($(this).val() == 1) {
                $('#ipd_date').show();               
                
            } else {
                $('#ipd_date').hide();                
            }
        });
        $('#ipd_date').hide();
        $('#patient_type').on('change',function(){
            if ($(this).val() == 1) {
                $('#ipd_date').show();               
                
            } else {
                $('#ipd_date').hide();                
            }
        });

        $('#currency_mmk').hide();

        $('#currency_thb').hide();

        $('#currency_lak').hide();
        

        $('#insurance').on('change',function(){
            var insurance_id = $(this).val();
            var assistance_store_id = $('#assistance_store_id').val();
            console.log('insurance_id', insurance_id);
            $.ajax({
                method : 'GET',
                url : '/admin/get_assistances/'+insurance_id,
                success : function(data){
                    $('#assistance option').remove();
                    $("#assistance").append('<option value="">Choose</option>');
                    $.each(data.data, function(){
                            $("#assistance").append('<option value="'+ this.id +'">'+ this.assistance_name +'</option>');
                    });
                    $('#assistance').val(assistance_store_id);
                    $('#assistance').select2().trigger('change');
                }
            })
        });

         $('#user').on('change',function(){
            if ($(this).val() == 3) {
                $('#ipd_start_date').show();
            } else {
                $('#ipd_start_date').hide();                
            }
        });

        $('#ipd_start_date').datepicker({
            dateFormat : 'yy-mm-dd'
        });
        $('#ipd_finish_date').datepicker({
            dateFormat : 'yy-mm-dd'
        });
        });
        function getOngoingData(patient_id,disease_id) {
            $.ajax({
                method : 'GET',
                url : '/admin/get_last_patient_state/'+patient_id+'/'+disease_id,
                success : function(data){
                    if (data.success) {
                        console.log(data.data);
                        $('#assistance_store_id').val(data.data.assistance_id);
                        $('#hospital').val(data.data.hospital_id);
                        $('#hospital').select2().trigger('change');
                        $('#receive_type').val(data.data.receive_type);
                        if (data.data.receive_type == 1) {
                            $('.byInsurance').show();
                            $('#gruntee_div').show();
                             $('#medicalinfoform_div').show();
                            $('#insurance').val(data.data.insurance_id);
                            $('#insurance').select2().change();
                        }else{
                            $('.byInsurance').hide();
                             $('#assistance_store_id').val('');
                        }
                    }else{
                        $('#assistance_store_id').val('');
                        $('#hospital').val('');
                        $('#hospital').select2().trigger('change');
                        $('#receive_type').val('');
                        $('#hospital').select2().trigger('change');
                        $('#receive_type').val('')
                        $('#insurance').select2().trigger('change');
                        $('#assistance').val('')
                        $('#assistance').select2().trigger('change');
                        $('.byInsurance').hide();
                        $('#gruntee_div').hide();
                        $('#medicalinfoform_div').hide();
                    }
                }
            });
        }
    </script>
    <script>
    var uploadedmedicalinvoiceMap = {}
    Dropzone.options.medicalinvoiceDropzone = {
        url: '{{ route('admin.medical_informations.storeMedia') }}',
        maxFilesize: 5, // MB
        addRemoveLinks: true,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
          size: 5
        },
        success: function (file, response) {
          $('form').append('<input type="hidden" name="medicalinvoice[]" value="' + response.name + '">')
          uploadedmedicalinvoiceMap[file.name] = response.name
        },
        removedfile: function (file) {
          file.previewElement.remove()
          var name = ''
          if (typeof file.file_name !== 'undefined') {
            name = file.file_name
          } else {
            name = uploadedmedicalinvoiceMap[file.name]
          }
          $('form').find('input[name="medicalinvoice[]"][value="' + name + '"]').remove()
        },
        init: function () {
    @if(isset($user) && $user->medicalinvoice)
              var files =
                {!! json_encode($user->medicalinvoice) !!}
                  for (var i in files) {
                  var file = files[i]
                  this.options.addedfile.call(this, file)
                  file.previewElement.classList.add('dz-complete')
                  $('form').append('<input type="hidden" name="medicalinvoice[]" value="' + file.file_name + '">')
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
        url: '{{ route('admin.medical_informations.storeMedia') }}',
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
    var uploadedmedicalinfoformMap = {}
    Dropzone.options.medicalinfoformDropzone = {
        url: '{{ route('admin.medical_informations.storeMedia') }}',
        maxFilesize: 5, // MB
        addRemoveLinks: true,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
          size: 5
        },
        success: function (file, response) {
          $('form').append('<input type="hidden" name="medicalinfoform[]" value="' + response.name + '">')
          uploadedmedicalinfoformMap[file.name] = response.name
        },
        removedfile: function (file) {
          file.previewElement.remove()
          var name = ''
          if (typeof file.file_name !== 'undefined') {
            name = file.file_name
          } else {
            name = uploadedmedicalinfoformMap[file.name]
          }
          $('form').find('input[name="medicalinfoform[]"][value="' + name + '"]').remove()
        },
        init: function () {
    @if(isset($user) && $user->medicalinfoform)
              var files =
                {!! json_encode($user->medicalinfoform) !!}
                  for (var i in files) {
                  var file = files[i]
                  this.options.addedfile.call(this, file)
                  file.previewElement.classList.add('dz-complete')
                  $('form').append('<input type="hidden" name="medicalinfoform[]" value="' + file.file_name + '">')
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

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
    }
</script>
@endsection
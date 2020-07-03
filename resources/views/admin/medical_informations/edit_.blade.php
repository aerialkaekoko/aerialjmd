@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.medical_informations.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.medical_informations.update", ['id'=>$medical_information->id,'user_id'=>$user_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="User">Patient *:</label>
                                <p class="text-danger">{{$medical_information->user->name}} {{$medical_information->user->family_name}}</p>
                               <input type="hidden" name="user_id" value="{{$user_id}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('treatment_date') ? 'has-error' : '' }}">
                                <label for="title">Treatment Date *:</label>
                                <input type="text" id="treatment_date" name="treatment_date" class="form-control" value="{{date('Y-m-d',strtotime($medical_information->treatment_date))}}" placeholder="Treatment Date">
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
                        <select class="form-control select2" id="hospital" name="hospital_id" >
                            @foreach($hospitals as $id => $hospital)
                                <option value="{{ $id }}" {{ (isset($medical_information) && $medical_information->hospital ? $medical_information->hospital->id : old('hospital_id')) == $id ? 'selected' : '' }} data-country="{{$id}}">{{ $hospital }}</option>
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
                            <select class="form-control select2" id="medical" name="medical_id" >
                                @foreach($medicals as $id => $medical)
                                    <option value="{{ $id }}" {{ (isset($medical_information) && $medical_information->medical ? $medical_information->medical->id : old('medical_id')) == $id ? 'selected' : '' }}>{{ $medical }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="Disease">Treatment :</label>
                            <select class="form-control" id="finish" name="finish" >
                                @if($medical_information->finish == 0)
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Finish</option>
                                @else
                                    <option value="0">Pending</option>
                                    <option value="1" selected>Finish</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Agt Ref No">Agt Ref No :</label>
                    <input type="text" id="agt_ref_no" name="agt_ref_no" value="{{$medical_information->agt_ref_no}}" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('appointment_date') ? 'has-error' : '' }}">
                        <label for="title">Appointment Date:</label>
                        <input type="text" id="appointment_date" name="appointment_date" class="form-control" value="{{date('Y-m-d',strtotime($medical_information->appointment_date))}}" placeholder="Treatment Date">
                            @if($errors->has('appointment_date'))
                                <p class="help-block">
                                    {{ $errors->first('appointment_date') }}
                                </p>
                            @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('appointment_status') ? 'has-error' : '' }}">
                        <label for="appointment_status">Appointment Status</label>
                        <select id="appointment_status" name="appointment_status" class="form-control" >
                            <option value="">{{ trans('global.pleaseSelect') }}</option>
                            @foreach(trans('cruds.appointment_status') as $key => $label)
                            <option value="{{ $key }}" {{ old( 'appointment_status', $medical_information->appointment_status)===( string)$key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Payment Type">Payment Type *:</label>
                        <select class="form-control" name="receive_type" id="receive_type" >
                            <option value="">Choose Payment Type</option>
                            @if ($medical_information->receive_type == 1)
                                <option value="1" selected>Insurance</option>
                                <option value="2">Cash</option>
                                <option value="3">Membership</option>
                                <option value="4">CreditCard</option>
                            @elseif($medical_information->receive_type == 3)
                                <option value="1">Insurance</option>
                                <option value="2">Cash</option>
                                <option value="3" selected>Membership</option>
                                <option value="4">CreditCard</option>
                            @elseif($medical_information->receive_type == 4)
                                <option value="1">Insurance</option>
                                <option value="2">Cash</option>
                                <option value="3">Membership</option>
                                <option value="4" selected>CreditCard</option>
                            @else
                                <option value="1">Insurance</option>
                                <option value="2" selected>Cash</option>
                                <option value="3">Membership</option>
                                <option value="4">CreditCard</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-6 byCardNo">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Insurance">Card No.</label>
                                <input type="text" id="card_no" value="{{$medical_information->card_no}}" name="card_no" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 byInsurance">
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label for="Insurance">Insurance *:</label>
                                <select class="form-control" name="insurance_id" id="insurance">
                                    <option value="">Choose Insurance</option>
                                    @foreach ($medical_information->user->insurances()->get() as $insurance)
                                        <option value="{{$insurance->id}}" {{ (isset($medical_information) && $medical_information->insurance ? $medical_information->insurance->id : old('insurance_id')) == $insurance->id ? 'selected' : '' }}>{{$insurance->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Assistance">Assistance :</label>
                                <select class="form-control" name="assistance_id" id="assistance">
                                    @if($assistances != null)
                                        @foreach ($assistances as $key=>$value)
                                            <option value="{{$key}}" {{ (isset($medical_information) && $medical_information->assistance ? $medical_information->assistance_id : old('assistance_id')) == $key ? 'selected' : '' }}>{{$value}}</option>
                                        @endforeach
                                    @endif
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
                        <input type="text" id="medical_amount" name="medical_amount" class="form-control text-right" onkeypress="return isNumberKey(event)" value="{{$medical_information->medical_amount}}" required="">
                        @if($errors->has('medical_amount'))
                            <p class="help-block">
                                {{ $errors->first('medical_amount') }}
                            </p>
                        @endif
                    </div>
                </div>                
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('other_fee') ? 'has-error' : '' }}">
                        <label for="other_fee">{{ trans('cruds.medical_informations.fields.other_fee') }}*</label>
                        <input type="text" id="other_fee" name="other_fee" class="form-control text-right" onkeypress="return isNumberKey(event)" value="{{$medical_information->other_fee}}" {{$medical_information->receive_type == 1 ? '': 'readonly'}}>
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
                        <label for="title">Document Date *:</label>
                        <input type="text" id="document_date" name="document_date" class="form-control" value="{{$medical_information->document_date}}" placeholder="Document to Office Date">
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
                        <input type="text" id="insentive" name="insentive" class="form-control"
                            value="{{$medical_information->insentive}}">
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                    <label for="Side Response">Side Response :</label>
                    <select class="form-control" name="side_response" id="side_response" >
                            <option value="">Choose</option>
                            @if ($medical_information->side_response == 1)
                                <option value="1" selected>Phone</option>
                                <option value="2">Person</option>
                            @else
                                <option value="1">Phone</option>
                                <option value="2" selected>Person</option>
                            @endif
                        </select>
                </div>
                <div class="col-md-6">
                    <label for="Translator Name">Translator Name :</label>
                    <input type="text" id="translator_name" name="translator_name" class="form-control" value="{{$medical_information->translator_name}}">
                </div>
            </div>            

            <div class="row" id="ipd_div" style="{{ $medical_information->hospital->country == 1 ? 'display: none' : '' }}">
                <div class="col-md-6">
                    <div class="form-group"  >
                        <label for="Patient Type">IPD/OPD</label>
                        <select class="form-control" name="patient_type" id="patient_type" >
                            <option value="">Choose Type</option>
                            @if ($medical_information->patient_type == 1)
                                <option value="1" selected="">IPD</option>
                                <option value="2">OPD</option>
                            @else
                                <option value="1">IPD</option>
                                <option value="2" selected="">OPD</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row" id="ipd_date" style="{{ $medical_information->patient_type == 1 ? '' : 'display:none' }}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Start Date">Start Date</label>
                                <input type="text" class="form-control" name="ipd_start_date" id="ipd_start_date" autocomplete="off" value="{{date('Y-m-d',strtotime($medical_information->ipd_start_date))}}">
                                <span class="error_ipd_start_date text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Finish Date">Finish Date</label>
                                <input type="text" class="form-control" name="ipd_finish_date" id="ipd_finish_date" autocomplete="off" value="{{date('Y-m-d',strtotime($medical_information->ipd_finish_date))}}">
                                <span class="error_ipd_finish_date text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-6">
                   
                </div>
                <div class="col-md-6">
                    <label for="Sympton">Sympton :</label>
                    <textarea class="form-control" id="sympton" name="sympton" rows="2">{{$medical_information->sympton}}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('medicalinvoice') ? 'has-error' : '' }}"  id="medicalinvoice_div">
                        <label for="medicalinvoice">Medical Invoice</label>
                        <div class="needsclick dropzone" id="medicalinvoice-dropzone">
                        </div>
                        @if($errors->has('medicalinvoice'))
                        <p class="help-block">
                            {{ $errors->first('medicalinvoice') }}
                        </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">                    
                    <label for="Sympton">Remark :</label>
                    <textarea class="form-control" id="remark" name="remark" rows="2">{{$medical_information->remark}}</textarea>                
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- gruntee -->
                    <div class="form-group {{ $errors->has('gruntee') ? 'has-error' : '' }}" style="{{$medical_information->receive_type == 2?'display:none':''}}" id="gruntee_div">
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
                    <!-- gruntee -->
                </div>
                <div class="col-md-6">
                    <!-- medicalinfoform -->
                    <div class="form-group {{ $errors->has('medicalinfoform') ? 'has-error' : '' }}" style="{{$medical_information->receive_type == 2?'display:none':''}}" id="medicalinfoform_div">
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
                    <!-- medicalinfoform -->
                </div>
                
            </div>
            <div class="service my-2" style="">
                <h5>Service Time
                    @if ($medical_information->patient_type == 1)
                        <i class="fas text-success fa-plus-circle create-service" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModal"></i>
                    @endif
                </h5>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Date</th>
                      <th scope="col">In Time</th>
                      <th scope="col">Out Time</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @forelse ($medical_information->services as $service)
                        <tr>
                          <th>{{$service->service_date??'-'}}</th>
                          <td>{{date('h:i A',strtotime($service->intime))}}</td>
                          <td>{{date('h:i A',strtotime($service->outtime))}}</td>
                          <td>
                                <a class="btn btn-xs btn-warning edit-service" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModal"  data-id="{{$service->id}}" data-service_date="{{$service->service_date??'-'}}" data-intime="{{$service->intime}}" data-outtime="{{$service->outtime}}"><i class="fas fa-edit text-white"></i></a>
                                  <a href="/admin/{{$medical_information->user_id}}/{{$medical_information->id}}/services/{{$service->id}}" class="btn btn-xs btn-danger">
                                            <i class='fas fa-trash'></i>
                                 </a>
                          </td>
                        </tr>
                    @empty
                        <tr><td colspan="3">No Service Time Yet !....</td></tr>
                    @endforelse
                  </tbody>
                </table>
            </div>
            
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
<!-- Service Model -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Service Time</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  method="post" class="service-form">
        @csrf
            <span class="update_method"></span>
          <input type="hidden" class="medical_id" name="id" value="{{$medical_information->id}}">
          <input type="hidden" name="user_id" value="{{$medical_information->user_id}}">
          <div class="modal-body">
            <label for="From"> Date</label>
            <input type="text" id="service_date" name="service_date" class="form-control" value="">
            <label for="From"> In Time </label>
            <input type="time" id="service_time" name="service_time" class="form-control">
            <label for="To">Out Time</label>
            <input type="time" id="service_outtime" name="service_outtime" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary service-submit" >Service Time</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/jquery-repeater.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.create-service').on('click',function(){
                var formAction = "{{route('admin.storeService')}}";
                $('.service-form').attr('action', formAction);
                $('.service-submit').html('Add Service Time');
            });
            $('.edit-service').on('click',function(){
                var id = $(this).data('id');
                var service_date = $(this).data('service_date');
                if (service_date == '-') {
                    $('#service_date').attr('readonly',true)
                }
                var intime = $(this).data('intime');
                var outtime = $(this).data('outtime');
                console.log('intime',intime);
                var formAction = "/admin/services/"+id;
                $('#service_date').val(service_date);
                $('#service_time').val(intime);
                $('#service_outtime').val(outtime);
                $(".update_method").html("<input type='hidden' name='_method' value='PUT'>")
                $('.service-form').attr('action', formAction);
                $('.service-submit').html('Update Service Time');
            });
            $('#treatment_date').datepicker({
                dateFormat : 'yy-mm-dd',
            });
            $('#document_date').datepicker({
                dateFormat : 'yy-mm-dd',
            });
            $('#service_date').datepicker({
                dateFormat : 'yy-mm-dd',
            });
            $('#service_date_edit').datepicker({
                dateFormat : 'yy-mm-dd',
            });
        if ($('#receive_type').val() == 1) {
            $('.byInsurance').show();
            $('.byCardNo').hide();
        }else if ($('#receive_type').val() == 4) {
            $('.byInsurance').hide();
            $('.byCardNo').show();
        }
         else{
            $('.byInsurance').hide();
            $('.byCardNo').hide();
        }
        
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
            } else {
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

         $('#hospital').on('change',function(){
            console.log('hoos',$(this).find(':selected').data('country'))
            if ($(this).find(':selected').data('country') == 1) {              
                $('#ipd_div').show(); 
            } else {
                $('#ipd_div').show();                
            }
        });

        $('#insurance').on('change',function(){
            var insurance_id = $(this).val();
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
                }
            })
        });

        $('#ipd_start_date').datepicker({
            dateFormat : 'yy-mm-dd'
        });
        $('#ipd_finish_date').datepicker({
            dateFormat : 'yy-mm-dd'
        });
    });
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
    @if(isset($medical_information) && $medical_information->medicalinvoice)
              var files =
                {!! json_encode($medical_information->medicalinvoice) !!}
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
@if(isset($medical_information) && $medical_information->gruntee)
          var files =
            {!! json_encode($medical_information->gruntee) !!}
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
        maxFilesize: 6, // MB
        addRemoveLinks: true,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
          size: 6
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
    @if(isset($medical_information) && $medical_information->medicalinfoform)
              var files =
                {!! json_encode($medical_information->medicalinfoform) !!}
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
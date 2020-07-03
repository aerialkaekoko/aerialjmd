@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.invoices.title_singular') }}
        </div>
        <div class="card-body">
            <form action="" class="invoice-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Invoice Code">Invoice Code *:</label>
                            <input type="text" class="form-control" name="invoice_code" id="invoice_code" placeholder="Enter Invoice Code" value="JMD-{{$refID}}" readonly="">
                            <span class="error_invoice_code text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Reference No">Reference No *:</label>
                            <input type="text" class="form-control" name="reference_no" id="reference_no" placeholder="Enter Reference No" readonly value="{{$medical_info?$medical_info->history_code:'-'}}">
                            <span class="error_reference_no text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="User">Patient *:</label>
                            <select class="form-control select2" id="user" name="user_id" >
                                @foreach($users as $id => $user)
                                    <option value="{{ $id }}" {{ $create == 1 ?($user_id == $id ? 'selected' : '') : '' }}>{{ $user }}</option>
                                @endforeach
                            </select>
                            <span class="error_user_id text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <input type="hidden" name="medical_information_id" id="medical_information_id" value="{{$medical_info?$medical_info->id:''}}">
                    <div class="col-md-3">
                        <label for="Hospital">Hospital *:</label><br>
                        <p id="hospital">{{$medical_info? !empty($medical_info->hospital->name) ? $medical_info->hospital->name : "-" :'-'}}</p>
                    </div>
                    <div class="col-md-3">
                        <label for="Disease">Disease *:</label><br>
                        <p id="disease">{{$medical_info?$medical_info->medical->disease_name:'-'}}</p>
                    </div>
                    <div class="col-md-3">
                        <label for="Medical Amount">Medical Amount *:</label><br>
                        <p id="medical_amount">{{$medical_info?$medical_info->medical_amount:'-'}}</p>
                    </div>
                    <div class="col-md-3">
                        <label for="Payment Type">Payment Type *:</label><br>
                        <p id="payment_type">{{$medical_info?trans('cruds.receive_type')[$medical_info->receive_type]:'-' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Insurance">Insurance *:</label><br>
                            <p id="insurance">{{ $medical_info?$medical_info->receive_type== 1 ? !empty($medical_info->insurance->company_name) ? $medical_info->insurance->company_name : '-' :'-' :'-'}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Invoice Code">Due Date *:</label>
                            <input type="text" class="form-control" name="due_date" id="due_date" placeholder="Enter Due Date" autocomplete="off">
                            <span class="error_due_date text-danger"></span>
                        </div>
                    </div>

                </div>

                <hr/>
                <h4>Expenses</h4>
                <div class="row">                    
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('ba_svf') ? 'has-error' : '' }}">
                            <label for="ba_svf">BA SVF</label>
                            <input type="text" id="ba_svf" name="ba_svf" class="form-control text-right" onkeypress="return isNumberKey(event)" value="0">
                            @if($errors->has('ba_svf'))
                                <p class="help-block">
                                    {{ $errors->first('ba_svf') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 byCash">
                        <div class="form-group {{ $errors->has('case_fee') ? 'has-error' : '' }}">
                            <label for="case_fee">Case Fee</label>
                            <input type="text" id="case_fee" name="case_fee" class="form-control text-right" onkeypress="return isNumberKey(event)" value="0" {{$medical_info?$medical_info->receive_type == 2 ?'readonly':'':''}}>
                            @if($errors->has('case_fee'))
                                <p class="help-block">
                                    {{ $errors->first('case_fee') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="repeater">
                    {{-- <h4>Expenses</h4> --}}
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless" style="display: none;">
                                <thead>
                                    <tr>
                                        <th width="60%">Expense Type</th>
                                        <th>Amount</th>
                                        <th>
                                            <input data-repeater-create type="button" class="btn btn-sm btn-primary" value="Add Expense"/>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody data-repeater-list="expense_group">
                                    <tr data-repeater-item>
                                        <td>
                                            <input type="text" name="expense_type" id="expense_type" class="form-control" placeholder="Enter Expense Type">
                                        </td>
                                        <td>
                                            <input type="text" name="expense_amount" id="expense_amount" class="form-control text-right" value="0">
                                        </td>
                                        <td>
                                            <input data-repeater-delete type="button" class="btn btn-sm btn-danger" value="x"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                </div>
                
                <div class="row">
                    <div class="col-md-12 text-right"><span id="success_msg" class="text-success"></span></div>
                </div>
                <div class="row">
                    <div class="col-md-6">                        
                        <a href="{{ URL::previous() }}" class="btn btn-md btn-danger">Cancel</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <input type="button" value="Add Invoice" id="addinvoice" class="btn btn-md btn-primary">
                        <a href="{{route('admin.invoices.index')}}" class="btn btn-md btn-primary" id="tolist">To List</a>
                        <a href="" class="btn btn-md btn-success" target="_blank" id="pdf">PDF</a>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" id="create" value="{{$create}}">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Choose Medical Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-info">
                            <th></th>
                            <th>History Code</th>
                            <th>Hospital</th>
                            <th>Disease</th>
                            <th>Medical Amount</th>
                            <th>Payment Type</th>
                            <th>Insurance</th>
                        </tr>
                    </thead>
                    <tbody id="medical_info">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modal_close">Close</button>
            <button type="button" class="btn btn-primary" id="add_medical_info">Add Medical Info</button>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/jquery-repeater.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#modal_close').on('click',function(){
                $('#user').val('');
                $('#user').select2().trigger('change');
            })
            $('#tolist').hide();
            $('#pdf').hide();
            $('#addinvoice').on('click',function(e){
               e.preventDefault();
               $(this).html('Sending..');
               var data = $('.invoice-form').serialize();
               console.log(data);
               $.ajax({
                   type : "POST",
                   url: "{{ route('admin.invoices.store') }}",
                   data : data,
                   success : function(data){
                       if (data.success) {
                            $('#tolist').show();
                            $('#pdf').show();
                            $('#addinvoice').hide();
                            $('.error_invoice_code').text('')
                            $('.error_reference_no').text('')
                            $('.error_user_id').text('')
                            $('.error_due_date').text('')
                            $('#success_msg').text('Added Successfully')
                            $("#pdf").attr('href','/admin/invoices/downloadpdf/'+data.data.id);
                       }
                   },
                   error : function(data){
                       console.log('error',data.responseJSON.errors);
                       $('.error_invoice_code').text(data.responseJSON.errors.invoice_code)
                       $('.error_reference_no').text(data.responseJSON.errors.reference_no)
                       $('.error_user_id').text(data.responseJSON.errors.user_id)
                       $('.error_due_date').text(data.responseJSON.errors.due_date)
                   }
               })
            })
            $('.repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'expense_amount': 0,
            },
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        });
        $('.byInsurance').hide();
        $('#payment_type').on('change',function(){
            if ($(this).val() == 1) {
                $('.byInsurance').show();
                $('#assistance_id').attr('required',true);
                $('#insurance_id').attr('required',true);
            } else {
                $('.byInsurance').hide();
                $('#assistance_id').attr('required',false);
                $('#insurance_id').attr('required',false);
            }
        });

        var medical_info_arr = [];
        $('#user').on('change',function(){
            var user_id = $(this).val();
            var current_login_user = @json(Auth::user());
            console.log('current_login_user',current_login_user.country)
            if (user_id != '') {
                $('.modal').modal('show');
                $.ajax({
                    method : 'GET',
                    url : '/admin/get_medical_info/'+user_id,
                    success : function(data){
                    if (data.success) {
                        console.log(data);
                        var medical_info_data = '';
                        $.each(data.data,function(key,value){
                            medical_info_arr.push(value);
                            var insurance_company;
                            var receive_type;
                            var md_status;
                            receive_type = @json(trans('cruds.receive_type'))[value.receive_type]
                            console.log('rec',receive_type);
                            if (value.insurance != null) {
                                insurance_company = value.insurance.company_name;
                            } else {
                                insurance_company = '-';
                            }
                            if (value.status == 1) {
                                md_status = 'disabled'
                            } else {
                                if (current_login_user.country == value.hospital.country || current_login_user.name == 'admin') {
                                    md_status = ''
                                }else{
                                    md_status = 'disabled'
                                }
                            }
                            medical_info_data += '<tr><td><input type="radio" '+md_status+' name="medical_info" value="'+value.id+'" data-reference_no="'+value.history_code+'" data-hospital="'+value.hospital.name+'" data-disease="'+value.medical.disease_name+'" data-cash="'+value.receive_type+'" data-medical_amount="'+value.medical_amount+'" data-receive_type="'+receive_type+'" data-insurance_company="'+insurance_company+'"></td>'
                            medical_info_data += '<td>'+value.history_code+'</td>'
                            medical_info_data += '<td>'+value.hospital.name+'</td>'
                            medical_info_data += '<td>'+value.medical.disease_name+'</td>'
                            medical_info_data += '<td>'+value.medical_amount+'</td>';
                            medical_info_data += '<td>'+receive_type+'</td>';
                            medical_info_data += '<td>'+insurance_company +'</td>'
                            medical_info_data += '</tr>'
                        });
                        $('#medical_info').html(medical_info_data);
                    }
                    }
                })
            }
        });
        $('#add_medical_info').on('click',function(){
            $('.modal').modal('hide');
            var check_item = $("input[name='medical_info']:checked");
            console.log('check_item',check_item.data())
            $('#medical_information_id').val(check_item.val());
            $('#reference_no').val(check_item.data('reference_no'));
            $('#hospital').text(check_item.data('hospital'));
            $('#disease').text(check_item.data('disease'));
            $('#payment_type').text(check_item.data('receive_type'));
            $('#insurance').text(check_item.data('insurance_company'));
            $('#medical_amount').text(check_item.data('medical_amount'));
            if (check_item.data('receive_type') == "Cash") {
                $('#case_fee').attr('readonly',true);
            }else{
                 $('#case_fee').attr('readonly',false);
            }
        })
        $('#due_date').datepicker({
            dateFormat : 'yy-mm-dd',
            minDate : 0,
        });

        });

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
}
    </script>
@endsection

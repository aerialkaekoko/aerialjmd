@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.invoices.title_singular') }}
        </div>
        <div class="card-body">
            <form action="{{ route("admin.invoices.update",[$invoice->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Invoice Code">Invoice Code *:</label>
                            <input type="text" class="form-control" name="invoice_code" id="invoice_code" placeholder="Enter Invoice Code" value="{{$invoice->invoice_code}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Reference No">Reference No *:</label>
                            <input type="text" class="form-control" name="reference_no" id="reference_no" placeholder="Enter Reference No" value="{{$invoice->reference_no}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="User">User *:</label>
                            <input type="hidden" name="user_id" value="{{$invoice->user_id}}">
                            <input type="text" class="form-control" value="{{$invoice->user->name}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="medical_information_id" id="medical_information_id" value="{{$invoice->medical_information_id}}">
                      <div class="col-md-3">
                            <label for="Hospital">Hospital *:</label><br>
                            <p id="hospital">{{ !empty($invoice->medical_info->hospital->name) ? $invoice->medical_info->hospital->name : "-" ?? '' }}</p>
                      </div>
                      <div class="col-md-3">
                          <label for="Disease">Disease *:</label><br>
                          <p id="disease">{{ $invoice->medical_info->medical->disease_name ?? '' }}</p>
                      </div>
                      <div class="col-md-3">
                          <label for="Medical Amount">Medical Amount *:</label><br>
                          <p id="medical_amount">{{$invoice->medical_info->medical_amount}}</p>
                      </div>
                      <div class="col-md-3">
                        <label for="Payment Type">Payment Type *:</label><br>
                        <p id="payment_type">{{ trans('cruds.receive_type')[$invoice->medical_info->receive_type] ?? '' }}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Insurance">Insurance *:</label><br>
                            <p id="insurance">{{ !empty($invoice->medical_info->insurance->company_name) ? $invoice->medical_info->insurance->company_name : '-' ?? '-' }}</p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Invoice Code">Due Date *:</label>
                            <input type="text" class="form-control" name="due_date" id="due_date" value=" {{date('Y-m-d',strtotime($invoice->due_date))}}" placeholder="Enter Due Date" autocomplete="off">
                            <span class="error_due_date text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <label for="">Status:</label><br>
                        <span class="badge badge-success mr-2">Paid</span><input type="checkbox" name="status" {{$invoice->status == 1 ?'checked':''}}>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('ba_svf') ? 'has-error' : '' }}">
                            <label for="ba_svf">BA SVF</label>
                            <input type="number" id="ba_svf" name="ba_svf" class="form-control text-right" value="{{ old('ba_svf', isset($invoice) ? $invoice->ba_svf : '') }}">
                            @if($errors->has('ba_svf'))
                                <p class="help-block">
                                    {{ $errors->first('ba_svf') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('case_fee') ? 'has-error' : '' }}">
                            <label for="case_fee">Case Fee</label>
                            <input type="number" id="case_fee" name="case_fee" class="form-control text-right" value="{{ old('case_fee', isset($invoice) ? $invoice->case_fee : '') }}" {{$invoice->medical_info->receive_type == 1?'':'readonly'}}>
                            @if($errors->has('case_fee'))
                                <p class="help-block">
                                    {{ $errors->first('case_fee') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                {{--
                <div class="repeater card p-4">
                    <h4>Expenses</h4>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="alert"></div>
                            <table class="table table-borderless">
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
                                    @if ($medical_expenses->count() > 0)
                                        @foreach ($medical_expenses as $key=>$value)
                                            <tr data-repeater-item>
                                                <td>
                                                    <input type="text" name="expense_type" id="expense_type" class="form-control" value="{{$value->expense_type}}" placeholder="Enter Expense Type">
                                                </td>
                                                <td>
                                                    <input type="text" name="expense_amount" id="expense_amount" class="form-control text-right" value="{{$value->expense_amount}}">
                                                </td>
                                                <td>
                                                    <input type="hidden" name="expense_id" id="expense_id" value="{{$value->id}}">
                                                    <input data-repeater-delete type="button" class="btn btn-sm btn-danger" name="expense_delete" data-expense_id={{$value->id}} value="x"/>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr data-repeater-item>
                                            <td>
                                                <input type="text" name="expense_type" id="expense_type" class="form-control" value="" placeholder="Enter Expense Type">
                                            </td>
                                            <td>
                                                <input type="text" name="expense_amount" id="expense_amount" class="form-control text-right" value="0">
                                            </td>
                                            <td>
                                                <input type="hidden" name="expense_id" id="expense_id" value="">
                                                <input data-repeater-delete type="button"  class="btn btn-sm btn-danger" value="x"/>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                --}}
                <div class="row">
                    <div class="col-md-12 text-right">
                        <input type="submit" value="Update Invoice" class="btn btn-md btn-primary">
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
            $('.repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'expense_amount': 0,
                'expense_delete' : 'x',
            },
            show: function () {
                $(this).slideDown();
            },
            // hide: function (deleteElement) {
            //     if(confirm('Are you sure you want to delete this element?')) {
            //         $(this).slideUp(deleteElement);
            //     }
            // },
            isFirstItemUndeletable: false
        });
        $('#user').on('change',function(){
            var user_id = $(this).val();
            $.ajax({
                method : 'GET',
                url : '/admin/get_medical_info/'+user_id,
                success : function(data){
                   $('#medical_information_id').val(data.data.id);
                   $('#hospital').text(data.data.hospital);
                   $('#disease').text(data.data.disease_name);
                   $('#payment_type').text(data.data.payment_type);
                   $('#insurance').text(data.data.insurance);
                   $('#medical_amount').text(data.data.medical_amount);
                }
            })
        });
        $('#due_date').datepicker({
            dateFormat : 'yy-mm-dd',
            minDate : 0
        });
        });
        function expenseDelete(index,e) {
            // if(confirm('Are you sure you want to delete this element?')) {
                var expense_id = $('#expense_id'+index).val();
                $.ajax({
                    method : 'GET',
                    url :'/admin/delete_expense/'+expense_id,
                    success : function(data){
                        if (data.success) {
                            $('.alert').html("<div class='alert alert-success' role='alert'>Delete Successfully</div>");
                        }
                    }
                })
            // }
           
        }
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
    }
    </script>
@endsection
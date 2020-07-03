@extends('layouts.admin')
@section('styles')
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />
<style>
    button.btn.btn-danger.delete_row_btn {
    margin-top: -73px;
    }
    </style>
@endsection
@section('content')
<form action="{{route('admin.invoices.updateform2',$invoice->id)}}" method="post">
    @csrf
    <input type="hidden" id="usd" value="{{$exchange->exchange_usd}}">
    <input type="hidden" id="thb" value="{{$exchange->exchange_thb}}">
    <input type="hidden" id="mmk" value="{{$exchange->exchange_mmk}}">
    <input type="hidden" id="lak" value="{{$exchange->exchange_lak}}">
    <div class="card">
        <h1 class="text-center">Edit Invoice Form 2</h1>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="Invoice No" class="col-sm-4 col-form-label">INV.NO :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="invoice_code" name="invoice_code"
                                value="{{$invoice_code}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="INV Date" class="col-sm-4 col-form-label">INV Date:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="invoice_date" name="invoice_date"
                                value="{{$invoice_date}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="To" class="col-sm-4 col-form-label">To :</label>
                        <div class="col-sm-8">
                            <select name="to" id="to" class="form-control">
                                @foreach ($to_data as $key=>$value)
                                 <option value="{{$key}}" @if($key==$invoiceassistance_id) selected @endif> {{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="Insurance" class="col-sm-4 col-form-label">Insurance :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="insurance"
                                value="{{isset($invoice)&& $invoice->medical_info->insurance ? $invoice->medical_info->insurance->company_name: '-'}}"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Assistance" class="col-sm-4 col-form-label">Asstc. Co. :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="assistance"
                                value="{{isset($invoice)&& $invoice->medical_info->assistance ? $invoice->medical_info->assistance->assistance_name: '-'}}"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Send On Date" class="col-sm-4 col-form-label">Send On Date :</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="send_date" name="send_date"
                                value="{{isset($invoice) ? $invoice->send_date: ''}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Paid On Date" class="col-sm-4 col-form-label">Paid On Date :</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="paid_date" name="paid_date"
                                value="{{isset($invoice) ? $invoice->paid_date: ''}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body repeater">
            <table class="table table-borderless" id="tab_logic">
                <thead>
                    <tr>
                        <th scope="col" width="3%">#</th>
                        <th scope="col" width="30%">Description</th>
                        <th scope="col" width="5%">Qty</th>
                        <th scope="col" width="9%">MD Expense</th>
                        <th scope="col" width="6%">Currency</th>
                        <th scope="col" width="10%">Interpreter Fee</th>
                        <th scope="col" width="6%">Currency</th>
                        <th scope="col" width="10%">Amount</th>
                        <th scope="col" width="6%">Currency</th>
                    </tr>
                </thead>
                <tbody data-repeater-list="data">
                    {{-- @foreach($editinvoice as $key=>$item)
                    <h1>{{ App\MedicalInformation::find($item->medical_information_id)->ba_ref_no }}
                    </h1>
                    @endforeach --}}
                 
                    @foreach($editinvoice as $key=>$item)
                    @php $tkey=$key+1; @endphp
                    <tr data-repeater-item>
                        <td class="p-1">
                            <span name="no" id="no"></span>
                            <input type="hidden" name="medical_information_id" id="medical_information_id"
                                value="{{$item->medical_information_id}}">
                            <input type="hidden" name="user_id" id="user_id" value="{{$item->user->id}}">
                            <input type="hidden" name="invoice_id" id="invoice_id" value="{{$item->id}}">
                        </td>
                        <td class="p-1">
                            <div class="form-group row">
                                <label for="BA Ref No" class="col-sm-5 col-form-label">BA Ref No :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="ba_ref_no" name="ba_ref_no"
                                        value="{{ App\MedicalInformation::find($item->medical_information_id)->ba_ref_no }}" data-srno="{{$tkey}}">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="Patient Name" class="col-sm-5 col-form-label">Patient Name :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="patient_name" name="patient_name"
                                        value="{{ App\MedicalInformation::find($item->medical_information_id)->user->family_name }} {{ App\MedicalInformation::find($item->medical_information_id)->user->name }}">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="Treatment Date" class="col-sm-5 col-form-label">Treatment Date :</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="treatment_date" name="treatment_date"
                                        value="{{App\MedicalInformation::find($item->medical_information_id)->date_of_visit}}"
                                        data-srno="{{$tkey}}">
                                </div>
                            </div> 
                        </td>
                 
                        <td class="p-1">
                            <div class="form-group">
                                <select name="qty" id="qty" class="qty form-control">
                                    @for ($qty = 1; $qty < 21; $qty++) <option value="{{$qty}}" @if($qty==$item->qty) selected @endif>{{$qty}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <input data-repeater-delete type="button" class="btn btn-md btn-danger" value="x" name="deleteItem" id="deleteItem"/>
                            </div>
                        </td>
                        <td class="p-1">
                            <input type="text" name="md_expense" id="md_expense" class="form-control md_expense"
                                value="{{App\MedicalInformation::find($item->medical_information_id)->medical_amount}}" min="0" step="0" value="0" />
                            <input type="text" class='hide mdtotal'>
                        </td>
                        <td class="p-1">
                            <select class="form-control currency" name="currency1" id="currency1" >
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{(App\MedicalInformation::find($item->medical_information_id)->currency == $key)?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-1">
                            <input type="text" name="interpreter_fee" id="interpreter_fee"
                        class="form-control interpreter_fee" data-srno="{{$tkey}}" min="0" step="0" value="{{$item->interpreter_fee}}">
                            <input type="text" class='hide interperetertotal'>
                        </td>
                        <td class="p-1">
                           <select class="form-control currency2" name="currency2" id="currency2" >
                            @foreach (trans('cruds.currency') as $key=>$value)
                            <option value="{{$key}}"
                                {{($item->currency_interpreter == $key)?'selected':''}}>{{$value}}
                            </option>
                            @endforeach
                        </select>
                        </td>
                        <td class="p-1"><input type="number" name='amount' placeholder='0.00'
                                class="form-control amount" readonly min="0" step="0" /></td>
                        <td class="p-1">
                            <select class="totalcurrency form-control" required>
                                <option value="">select currency</option>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{($item->change_currency == $key)?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach 
                </tbody>
            </table>
            <div class="row clearfix">
                <div class="col-md-12">
                    <input data-repeater-create class="btn btn-default pull-left" type="button" value="Add" />
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix" style="margin-top:20px">
        <div class="ml-auto col-md-5">
            <table class="table table-bordered table-hover" id="tab_logic_total">
                <tbody>
                    <tr>
                        <th class="text-center">Sub Total Amount</th>
                        <td class="text-center"><input type="number" name='Sub_Total_Amount' placeholder='0.00'
                                class="form-control Sub_Total_Amount" id="Sub_Total_Amount" readonly /></td>
                        <td class="">
                            <select class="totalcurrency form-control">
                                <option>select currency</option>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{("$changecurrency" == $key)?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center">Vatable</th>
                        <td class="text-center"><input type="number" name='Vatable' placeholder='0.00'
                                class="form-control Vatable" id="Vatable" readonly /></td>
                        <td>

                            <select class="totalcurrency form-control">
                                <option>select currency</option>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{("$changecurrency" == $key)?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @php
                    $percent = [5,7];
                    @endphp
                    <tr>
                        <th>
                            vat<select name="vat_percent" id="vat_percent" class="vat_percent" >
                            
                            @foreach ($percent as $key=>$value)
                            <option value="{{$value}}" {{$amount->vatable_percent == $value?'selected':''}}>{{$value}}%</option>
                            @endforeach
                        </select>
                        </th>
                        <td class="text-center">
                            <div class="input-group mb-2 mb-sm-0">
                                <input type="number" class="form-control vat_amount" name="vat_amount" id="vat_amount"
                                    placeholder="0" readonly>
                            </div>
                        </td>
                        <td>

                            <select class="totalcurrency form-control">
                                <option>select currency</option>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{("$changecurrency" == $key)?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center">Non - Vatable</th>
                        <td class="text-center"><input type="number" name='nonvatable' placeholder='0.00'
                                class="form-control nonvatable" id="nonvatable" readonly /></td>
                        <td>

                            <select class="totalcurrency form-control" >
                                <option>select currency</option>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{("$changecurrency" == $key)?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center">Grand Total</th>
                        <td class="text-center"><input type="number" name='Grand Total' id="total_amount"
                                placeholder='0.00' class="form-control" readonly /></td>
                        <td>
                            <select class="totalcurrency form-control" name="totalcurrency">
                                <option>select currency</option>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{("$changecurrency" == $key)?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
            <div class="text-right my-1">
                <input type="submit" value="Save Invoice" class="btn btn-md btn-success">
            </div>
           
</form>
<div class="text-left my-1">
    <form action="{{ route('admin.invoices.deleteform2', $invoice->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger delete_row_btn" type="submit">Delete</button>
    </form>
</div>
@endsection
@section('scripts')
<script>
    function deleteItem(index,event) {
         var id = $('#invoice_id'+index).val();
         $.ajax({
             url : '/admin/invoices/deleteItem/'+id,
             success : function(data){
                 if (data.success) {
                     calc();
                 }
             }
         })
     }
    function get_md_info(index,event) {
       var ba_ref_no = $('#ba_ref_no'+index).val();
       $( "#ba_ref_no"+index ).autocomplete({
         source: function( request, response ) {
           $.ajax( {
             url: "/admin/autocomplete",
             dataType: "json",
             data: {
               ba_ref_no: request.term
             },
             success: function( data ) {
               response(data)
             }
           } );
         },
         focus : function(event,ui){
             return false;
         },
         minLength: 2,
         select: function( event, ui ) {
             console.log('ref',$(this).val())
             $(this).val(ui.item.ba_ref_no)
             $('#md_expense'+index).val(ui.item.medical_amount)
             $('#patient_name'+index).val(ui.item.user.family_name +" "+ ui.item.user.name)
             $('#treatment_date'+index).val(ui.item.date_of_visit)
             $('#currency1'+index).val(ui.item.currency)
             $('#currency2'+index).val(ui.item.currency)
             $('#currency3'+index).val(ui.item.currency)
             $('#medical_information_id'+index).val(ui.item.id)
             $('#user_id'+index).val(ui.item.user.id)
             return false
         }
       } ).each(function(){
           $(this).data("ui-autocomplete")._renderItem = function(ul,item){
           console.log('item',item);
           return $("<li></li>").data("ui-autocomplete-item",item).append(item.ba_ref_no).appendTo(ul)
       };
       })
   }
   $(document).ready(function(){
       $(function () {
        var select = $('.totalcurrency');

        select.bind("change", function() {
        select.not(this).val(this.value);
        });

        
       $('.repeater').repeater({
               // (Optional)
               // start with an empty list of repeaters. Set your first (and only)
               // "data-repeater-item" with style="display:none;" and pass the
               // following configuration flag
               initEmpty: false    ,
               // (Optional)
               // "defaultValues" sets the values of added items.  The keys of
               // defaultValues refer to the value of the input's name attribute.
               // If a default value is not specified for an input, then it will
               // have its value cleared.
               defaultValues: {
                   'qty': 1,
                   'deleteItem': 'x',
                   'interpreter_fee':0,
                   
               },
               // (Optional)
               // "show" is called just after an item is added.  The item is hidden
               // at this point.  If a show callback is not given the item will
               // have $(this).show() called on it.
               show: function () {
                   $(this).slideDown();
               },
               // (Optional)
               // "hide" is called when a user clicks on a data-repeater-delete
               // element.  The item is still visible.  "hide" is passed a function
               // as its first argument which will properly remove the item.
               // "hide" allows for a confirmation step, to send a delete request
               // to the server, etc.  If a hide callback is not given the item
               // will be deleted.
            //    hide: function (deleteElement) {
            //        if(confirm('Are you sure you want to delete this element?')) {
            //            $(this).slideUp(deleteElement);
            //        }
            //    },
               // (Optional)
               // You can use this if you need to manually re-index the list
               // for example if you are using a drag and drop library to reorder
               // list items.
               ready: function (setIndexes) {
                   // $dragAndDrop.on('drop', setIndexes);
               },
               // (Optional)
               // Removes the delete button from the first list item,
               // defaults to false.
               isFirstItemUndeletable: true
           })
   var i={{$tkey}};
   calc();
   


   calc_total();
   });
   
 
   
   $('#tab_logic tbody').on('keyup change',function(){
   calc();
   });
   
   $('.qty').on('keyup change',function(){
   calc();
   });
   
   $('#vat_percent').on('keyup change',function(){
   calc_total();
   });
   
   
   });
   $(document).ready(function(){
    setInterval(calc, 1000);
    });
   
   function calc()
   {
   $('#tab_logic tbody tr').each(function(i, element) {
   var html = $(this).html();
   if(html!='')
   {
      
   var qty = $(this).find('.qty :selected').val();
   var md_expense = parseFloat($(this).find('.md_expense').val());
   
   var interpreter_fee = $(this).find('.interpreter_fee').val();
   var preamount=parseFloat(qty*interpreter_fee);
   var usd =parseFloat( $('#usd').val());
   var thb = parseFloat($('#thb').val());
   var mmk =parseFloat( $('#mmk').val()  );
   var lak =parseFloat( $('#lak').val()  );
   var currency=$(this).find('.currency').val();
   var currency1=$(this).find('.currency2').val();
  
   var totalcurrency=$(this).find('.totalcurrency').val();
   var new_amount = 0;
   var interperetertotal = 0;
   var mdtotal = 0;
   var amount=preamount + md_expense;
   
   
   
   
   $(this).find('.interperetertotal').val(preamount);
   
   if(currency==1 && currency1==1 && totalcurrency==1){
      
       $(this).find('.amount').val(amount.toFixed(2));
       $(this).find('.mdtotal').val(md_expense);
       $(this).find('.interperetertotal').val(preamount.toFixed(2));
      
   }else if(currency==1 && currency1==1 && totalcurrency==2){
        
        new_amount=amount*thb;
        interperetertotal=preamount*thb;
        mdtotal=md_expense*thb;
   
        $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
        $(this).find('.mdtotal').val(mdtotal.toFixed(2));
       $(this).find('.amount').val(new_amount.toFixed(2));
   }else if(currency==1 && currency1==1 && totalcurrency==3){
        new_amount=amount*mmk;
        interperetertotal=preamount*mmk;
        mdtotal=md_expense*mmk;

        $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
        $(this).find('.mdtotal').val(md_expense.toFixed(2));
       $(this).find('.amount').val(new_amount.toFixed(2));
   }
   else if(currency==1 && currency1==1 && totalcurrency==4){
       new_amount=amount*lak;
       interperetertotal=preamount*lak;
       mdtotal=md_expense*lak;
       $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
       $(this).find('.mdtotal').val(mdtotal.toFixed(2));
       $(this).find('.amount').val(new_amount.toFixed(2));
   }
   else if(currency==1 && currency1==1 && totalcurrency==4){
       new_amount=amount*lak;
       interperetertotal=preamount*lak;
       mdtotal=md_expense*lak;
       $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
       $(this).find('.mdtotal').val(mdtotal.toFixed(2));
       $(this).find('.amount').val(new_amount.toFixed(2));
   }
   else if(currency==1 && currency1==2 && totalcurrency==1){
       mdtotal=md_expense;
       interperetertotal=preamount/thb;
       new_amount=mdtotal + interperetertotal;
       $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
       $(this).find('.mdtotal').val(mdtotal.toFixed(2));
       $(this).find('.amount').val(new_amount.toFixed(2));
   }
   else if(currency==1 && currency1==2 && totalcurrency==2){
       mdtotal=md_expense*thb;
       interperetertotal=preamount;
       new_amount=mdtotal + interperetertotal;
       $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
       $(this).find('.mdtotal').val(mdtotal.toFixed(2));
       $(this).find('.amount').val(new_amount.toFixed(2));
   }
   else if(currency==1 && currency1==2 && totalcurrency==3){
       mdtotal=md_expense*mmk;
       preinter=preamount/thb;
       interperetertotal=preinter*mmk;
       new_amount=mdtotal + interperetertotal;
       $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
       $(this).find('.mdtotal').val(mdtotal.toFixed(2));
       $(this).find('.amount').val(new_amount.toFixed(2));
   }
   else if(currency==1 && currency1==2 && totalcurrency==4){
       mdtotal=md_expense*lak;
       preinter=preamount/thb;
       interperetertotal=preinter*lak;
       new_amount=mdtotal + interperetertotal;
       $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
       $(this).find('.mdtotal').val(mdtotal.toFixed(2));
       $(this).find('.amount').val(new_amount.toFixed(2));
   }
   else if(currency==1 && currency1==3 && totalcurrency==1){
    mdtotal=md_expense;
    interperetertotal=preamount/mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
   else if(currency==1 && currency1==3 && totalcurrency==2){
    mdtotal=md_expense*thb;
    preinter=preamount/mmk;
    interperetertotal=preinter*thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
   else if(currency==1 && currency1==3 && totalcurrency==3){
    mdtotal=md_expense*mmk;
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
   else if(currency==1 && currency1==3 && totalcurrency==4){
    mdtotal=md_expense*lak;
    preinter=preamount/mmk;
    interperetertotal=preinter*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
   else if(currency==1 && currency1==4 && totalcurrency==1){
    mdtotal=md_expense;
    interperetertotal=preamount/lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
   else if(currency==1 && currency1==4 && totalcurrency==2){
    mdtotal=md_expense*thb;
    preinter=preamount/lak;
    interperetertotal=preinter*thb;

    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
   else if(currency==1 && currency1==4 && totalcurrency==3){
    mdtotal=md_expense*mmk;
    preinter=preamount/lak;
    interperetertotal=preinter*mmk;

    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
   else if(currency==1 && currency1==4 && totalcurrency==4){
    mdtotal=md_expense*lak;
    interperetertotal=preamount;
     new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }


   else if(currency==2 && currency1==2 && totalcurrency==2){
    $(this).find('.amount').val(amount.toFixed(2));
    $(this).find('.mdtotal').val(md_expense);
    $(this).find('.interperetertotal').val(preamount.toFixed(2));
    }
    else if(currency==2 && currency1==1 && totalcurrency==1){
    mdtotal=md_expense/thb;
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==1 && totalcurrency==2){
     mdtotal=md_expense;
    interperetertotal=preamount*thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==1 && totalcurrency==3){
     premdtotal=md_expense/thb;
     mdtotal=premdtotal*mmk;
    interperetertotal=preamount*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==1 && totalcurrency==4){
     premdtotal=md_expense/thb;
     mdtotal=premdtotal*lak;
    interperetertotal=preamount*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==2 && totalcurrency==1){
     mdtotal=md_expense/thb;
     
    interperetertotal=preamount/thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==2 && totalcurrency==3){
     premdtotal=md_expense/thb;
     mdtotal=premdtotal*mmk;
     preinter=preamount/thb;
    interperetertotal=preinter*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==2 && totalcurrency==4){
     premdtotal=md_expense/thb;
     mdtotal=premdtotal*lak;
     preinter=preamount/thb;
    interperetertotal=preinter*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==3 && totalcurrency==1){
    mdtotal=md_expense/thb;
    
    interperetertotal=preamount/mmk;
   
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==3 && totalcurrency==2){
    mdtotal=md_expense;
    preinter=preamount/mmk;
    interperetertotal=preinter*thb;
   
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==3 && totalcurrency==3){
    permd=md_expense/thb;
    mdtotal=permd*mmk;
    
    interperetertotal=preamount;
   
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==3 && totalcurrency==4){
    permd=md_expense/thb;
    mdtotal=permd*lak;
    preinter=preamount/mmk;
    interperetertotal=preinter*lak;
    
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==4 && totalcurrency==1){
    mdtotal=md_expense/thb;
    interperetertotal=preamount/lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==4 && totalcurrency==2){
    mdtotal=md_expense;
    preinter=preamount/lak;
    interperetertotal=preinter*thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==4 && totalcurrency==3){
    ptotal=md_expense/thb;
    mdtotal=ptotal*mmk;
    preinter=preamount/lak;
    interperetertotal=preinter*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==4 && totalcurrency==4){
    ptotal=md_expense/thb;
    mdtotal=ptotal*lak;
    
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
     else if(currency==2 && currency1==2 && totalcurrency==2){
    $(this).find('.amount').val(amount.toFixed(2));
    $(this).find('.mdtotal').val(md_expense);
    $(this).find('.interperetertotal').val(preamount.toFixed(2));
    }
    else if(currency==2 && currency1==1 && totalcurrency==1){
    mdtotal=md_expense*thb;
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==1 && totalcurrency==2){
     mdtotal=md_expense;
    interperetertotal=preamount*thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==1 && totalcurrency==3){
     premdtotal=md_expense/thb;
     mdtotal=premdtotal*mmk;
    interperetertotal=preamount*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==1 && totalcurrency==4){
     premdtotal=md_expense*thb;
     mdtotal=premdtotal*lak;
    interperetertotal=preamount*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==2 && totalcurrency==1){
     mdtotal=md_expense*thb;
     
    interperetertotal=preamount/thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==2 && totalcurrency==3){
     premdtotal=md_expense/thb;
     mdtotal=premdtotal*mmk;
     preinter=preamount/thb;
    interperetertotal=preinter*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==2 && totalcurrency==4){
     premdtotal=md_expense/thb;
     mdtotal=premdtotal*lak;
     preinter=preamount/thb;
    interperetertotal=preinter*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==3 && totalcurrency==1){
    mdtotal=md_expense*thb;
    
    interperetertotal=preamount/mmk;
   
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==3 && totalcurrency==2){
    mdtotal=md_expense;
    preinter=preamount/mmk;
    interperetertotal=preinter*thb;
   
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==3 && totalcurrency==3){
    permd=md_expense/thb;
    mdtotal=permd*mmk;
    
    interperetertotal=preamount;
   
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==3 && totalcurrency==4){
    permd=md_expense/thb;
    mdtotal=permd*lak;
    preinter=preamount/mmk;
    interperetertotal=preinter*lak;
    
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==4 && totalcurrency==1){
    mdtotal=md_expense*thb;
    interperetertotal=preamount/lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==4 && totalcurrency==2){
    mdtotal=md_expense;
    preinter=preamount/lak;
    interperetertotal=preinter*thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==4 && totalcurrency==3){
    ptotal=md_expense/thb;
    mdtotal=ptotal*mmk;
    preinter=preamount/lak;
    interperetertotal=preinter*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==2 && currency1==4 && totalcurrency==4){
    ptotal=md_expense/thb;
    mdtotal=ptotal*lak;
    
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }

    else if(currency==3 && currency1==3 && totalcurrency==3){
    $(this).find('.amount').val(amount.toFixed(2));
    $(this).find('.mdtotal').val(md_expense);
    $(this).find('.interperetertotal').val(preamount.toFixed(2));
    }
    else if(currency==3 && currency1==1 && totalcurrency==1){
    mdtotal=md_expense/mmk;
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==1 && totalcurrency==2){
        premdtotal=md_expense/mmk;
        mdtotal=premdtotal*thb;
        interperetertotal=preamount*thb;
        new_amount=mdtotal + interperetertotal;
        $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
        $(this).find('.mdtotal').val(mdtotal.toFixed(2));
        $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==1 && totalcurrency==3){
        mdtotal=md_expense;
        interperetertotal=preamount*mmk;
        new_amount=mdtotal + interperetertotal;
        $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
        $(this).find('.mdtotal').val(mdtotal.toFixed(2));
        $(this).find('.amount').val(new_amount.toFixed(2));
    
    }
    else if(currency==3 && currency1==1 && totalcurrency==4){
    premdtotal=md_expense/mmk;
    mdtotal=premdtotal*lak;
    interperetertotal=preamount*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==2 && totalcurrency==1){
    mdtotal=md_expense/mmk;
    
    interperetertotal=preamount/thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==2 && totalcurrency==2){
    premdtotal=md_expense/mmk;
    mdtotal=premdtotal*thb;
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==2 && totalcurrency==3){
    mdtotal=md_expense;
    ptotal=preamount/thb;
    interperetertotal=ptotal*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==2 && totalcurrency==4){
    premdtotal=md_expense/mmk;
    mdtotal=premdtotal*lak;
    preinter=preamount/thb;
    interperetertotal=preinter*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==3 && totalcurrency==1){
    mdtotal=md_expense/mmk;
    interperetertotal=preamount/mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==3 && totalcurrency==2){
    ptotal=md_expense/mmk;
    mdtotal=ptotal*thb;
    preinter=preamount/mmk;
    interperetertotal=preinter*thb;
    
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    
    else if(currency==3 && currency1==3 && totalcurrency==4){
    permd=md_expense/mmk;
    mdtotal=permd*lak;
    preinter=preamount/mmk;
    interperetertotal=preinter*lak;
    
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==4 && totalcurrency==1){
    mdtotal=md_expense/mmk;
    interperetertotal=preamount/lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==4 && totalcurrency==2){
    ptotal=md_expense/mmk;
    mdtotal=ptotal*thb;
    preinter=preamount/lak;
    interperetertotal=preinter*thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==4 && totalcurrency==3){
    mdtotal=md_expense;
    preinter=preamount/lak;
    interperetertotal=preinter*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==3 && currency1==4 && totalcurrency==4){
    ptotal=md_expense/mmk;
    mdtotal=ptotal*lak;
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }

    // statusbar

    else if(currency==4 && currency1==4 && totalcurrency==4){
    $(this).find('.amount').val(amount.toFixed(2));
    $(this).find('.mdtotal').val(md_expense);
    $(this).find('.interperetertotal').val(preamount.toFixed(2));
    }
    else if(currency==4 && currency1==1 && totalcurrency==1){
    mdtotal=md_expense/lak;
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==1 && totalcurrency==2){
    premdtotal=md_expense/lak;
    mdtotal=premdtotal*thb;
    interperetertotal=preamount*thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==1 && totalcurrency==3){
    ptotal=md_expense/lak;
    mdtotal=ptotal*mmk;
    interperetertotal=preamount*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    
    }
    else if(currency==4 && currency1==1 && totalcurrency==4){
    mdtotal=md_expense;
    interperetertotal=preamount*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==2 && totalcurrency==1){
    mdtotal=md_expense/lak;
    interperetertotal=preamount/thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==2 && totalcurrency==2){
    premdtotal=md_expense/lak;
    mdtotal=premdtotal*thb;
    interperetertotal=preamount;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==2 && totalcurrency==3){
    premdtotal=md_expense/lak;
    mdtotal=premdtotal*mmk;
    pamount=preamount/thb;
    interperetertotal=pamount*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==2 && totalcurrency==4){
    mdtotal=md_expense;
    preinter=preamount/thb;
    interperetertotal=preinter*lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==3 && totalcurrency==1){
    mdtotal=md_expense/lak;
    interperetertotal=preamount/mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==3 && totalcurrency==2){
    ptotal=md_expense/lak;
    mdtotal=ptotal*thb;
    preinter=preamount/mmk;
    interperetertotal=preinter*thb;
    
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==3 && totalcurrency==3){
    ptotal=md_expense/lak;
    mdtotal=ptotal*mmk;
    interperetertotal=preamount;
    
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    
    else if(currency==4 && currency1==3 && totalcurrency==4){
    mdtotal=md_expense;
    preinter=preamount/mmk;
    interperetertotal=preinter*lak;
    
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==4 && totalcurrency==1){
    mdtotal=md_expense/lak;
    interperetertotal=preamount/lak;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==4 && totalcurrency==2){
    ptotal=md_expense/lak;
    mdtotal=ptotal*thb;
    preinter=preamount/lak;
    interperetertotal=preinter*thb;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }
    else if(currency==4 && currency1==4 && totalcurrency==3){
    ptotal=md_expense/lak;
    mdtotal=ptotal*mmk;
    preinter=preamount/lak;
    interperetertotal=preinter*mmk;
    new_amount=mdtotal + interperetertotal;
    $(this).find('.interperetertotal').val(interperetertotal.toFixed(2));
    $(this).find('.mdtotal').val(mdtotal.toFixed(2));
    $(this).find('.amount').val(new_amount.toFixed(2));
    }

   calc_total();
   }
   });
   }

   function calc_total()
   {
       
   total=0;
   $('.amount').each(function() {
   total += parseFloat($(this).val());
   });
   $('#Sub_Total_Amount').val(total.toFixed(2));
   
   vatable=0;
   $('.interperetertotal').each(function() {
   vatable += parseFloat($(this).val());
   });
   $('#Vatable').val(vatable.toFixed(2));
   
   nonvatable=0;
   $('.mdtotal').each(function() {
   nonvatable += parseFloat($(this).val());
   });
   $('#nonvatable').val(nonvatable.toFixed(2));
   
   vatpercent=$('#vat_percent option:selected').val();
   pre_vat_amount=vatable/100
   vat_amount=pre_vat_amount*vatpercent;
   
    $('#vat_amount').val(vat_amount.toFixed(2));
    grand_total=parseFloat (vat_amount) + parseFloat(vatable) + parseFloat(nonvatable);
   
    $('#total_amount').val(grand_total.toFixed(2));
   }
</script>
@endsection
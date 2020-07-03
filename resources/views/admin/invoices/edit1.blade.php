@extends('layouts.admin')
<style>
    button.btn.btn-danger.delete_row_btn {
        margin-top: -40px;
    }
</style>
@section('content')
<form action="{{route('admin.invoices.updateform1',[$invoice->id])}}" method="post">
    @csrf
    <input type="hidden" id="usd" value="{{$exchange->exchange_usd}}">
    <input type="hidden" id="thb" value="{{$exchange->exchange_thb}}">
    <input type="hidden" id="mmk" value="{{$exchange->exchange_mmk}}">
    <input type="hidden" id="lak" value="{{$exchange->exchange_lak}}">
    <input type="hidden" name="medical_information_id" class="form-control md_id" id="md_id"
        value="{{isset($medical_information) ? $medical_information->id: 0}}" readonly>
    <input type="hidden" name="user_id" class="form-control user_id" id="user_id"
        value="{{isset($medical_information) ? $medical_information->user->id: 0}}" readonly>
    <div class="card">
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
                        <label for="Ba Ref No" class="col-sm-4 col-form-label">BA REF NO :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="ba_ref_no"
                                value="{{isset($medical_information) ? $medical_information->ba_ref_no : ''}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Case No" class="col-sm-4 col-form-label">Case No :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="case_no"
                                value="{{isset($medical_information) ? $medical_information->gcl_case_no: '-'}}"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Patient Name" class="col-sm-4 col-form-label">Patient Name :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="patient_name"
                                value="{{isset($medical_information) ? $medical_information->user->family_name.' '.$medical_information->user->name : ''}}"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="MD Expense" class="col-sm-4 col-form-label">MD Expense :</label>
                        <div class="col-sm-6">

                            <input type="text" class="form-control md_expense" id="md_expense"
                                value="{{isset($invoice) ? $invoice->medical_info->medical_amount: 0}}"
                                readonly>
                                
                           
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control " disabled>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{($invoice->medical_info->currency == $key)?'selected':''}}>
                                    {{$value}}</option>
                                @endforeach
                            </select>
                            
                            
                        </div>   

                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="INV Date" class="col-sm-4 col-form-label">INV Date:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="invoice_date" name="invoice_date"
                                value="{{isset($invoice) ? $invoice->invoice_date : ''}}" readonly>
                        </div>
                    </div>
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
                        <label for="To" class="col-sm-4 col-form-label">To :</label>
                        <div class="col-sm-8">
                            <select name="to" id="to" class="form-control">
                                @foreach ($to_data as $key=>$value)
                                <option value="{{$key}}"
                                    {{ (isset($invoice) && $invoice->assistance_to ? $invoice->assistance_to->id : old('to')) == $key ? 'selected' : '' }}>
                                    {{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Treatment Date" class="col-sm-4 col-form-label">Treatment Date :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="treatment_date"
                                value="{{isset($invoice) ? $invoice->medical_info->date_of_visit: 0}}" readonly>
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
            {{-- @if($medical_information->opd_ipd==1)
            <div class="row" id="ipd_opd">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="Invoice No" class="col-sm-4 col-form-label">IPD Start Date :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="ipd_start_date"
                                value="{{isset($medical_information) ? $medical_information->ipd_start_date: 0}}"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="INV Date" class="col-sm-4 col-form-label">IPD End Date:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="ipd_finish_date" name="ipd_finish_date"
                                value="{{isset($medical_information) ? $medical_information->ipd_finish_date: 0}}"
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
            @endif --}}
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-borderless description_table" id='tab_logic'>
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="20%">Description</th>
                        <th scope="col" width="5%">Qty</th>
                        <th scope="col" width="10%">Unit Price</th>
                        <th scope="col" width="5%">Currency</th>
                        <th scope="col" width="10%">Amount</th>
                        <th scope="col" width="5%">Currency</th>
                        <th scope="col" width="5%">Vatable</th>
                    </tr>
                </thead>
                <tbody>
                  
                    {{$rqrow}}
                    @foreach ($item_descriptions as $i=>$data)
                     @php  $j=$i+1; @endphp
                     <tr>  
                        <th scope="row">
                            {{$i+1}}
                            <input type="hidden" name="data[{{$i}}][id_description]" value="{{isset($data)?$data->id: ''}}">
                        </th>
                        <td class="p-1">
                            <select name="data[{{$i}}][description]" id="description" class="form-control" >
                                @foreach ($descriptions as $key=>$value)
                                <option value="{{$key}}"
                                    {{ (isset($data) ? $data->invoice_description_id : old('description')) == $key ? 'selected' : '' }}>{{$value}}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-group row p-1">
                                <label for="To" class="col-sm-4 col-form-label">Remark :</label>
                                <div class="col-sm-8">
                                    <input type="text" name="data[{{$i}}][remark]" class="form-control" id="remark"
                                        value="{{isset($data)?$data->remark: ''}}" >
                                </div>
                            </div>
                        </td>
                     
                        <td class="p-1">
                            <select name="data[{{$i}}][qty]" id="qty{{$i}}" class="qty">
                                @for ($qty = 1; $qty < 21; $qty++) 
                                <option value="{{$qty}}" @if($qty==$data->qty) selected @endif>{{$qty}}</option>
                                @endfor
                            </select>
                        </td>
                        <td class="p-1">
                            <input type="text" name="data[{{$i}}][unit_price]" class="unit_price form-control" id="unit_price" data-id="{{$i}}"
                                class="form-control" value="{{ isset($data) ? $data->unit_price : ''}}" >
                        </td>
                        <td class="p-1">
                            <select class="form-control currency1" name='data[{{$i}}][currency1]'>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{($data->currency1 == $key)?'selected':''}}>
                                    {{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-1">
                            <input type="text" name="data[{{$i}}][amount]" id="amount{{$i}}" class="form-control amount" min="0" step="0"
                                value="0" readonly>
                        </td>
                        <td class="p-1">
                            <select class="form-control currency" id="currency{{$i}}" data-id="{{$i}}" name="currency">
                                <option value="">Choose</option>
                                @foreach (trans('cruds.currency') as $key=>$value)
                                <option value="{{$key}}" {{($invoice->change_currency == $key)?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-1 text-center">
                            <input type="checkbox"  value="{{$data->vatable_status}}" id="vatable{{$j}}" class="cvatabel ml-auto" @if($data->vatable_status > 0) checked @endif>
                               @if($data->vatable_status == 0)
                               <input type="text" name="data[{{$i}}][vatable]" class="hide vatableamount" id="show{{$j}}" value="0">
                               
                               @else  
                                 <input type="text" name="data[{{$i}}][vatable]" class="hide vatableamount" id="show{{$j}}" value="0">
                               @endif  

                        </td>
                        </tr>
                    @endforeach
                    @if($rqrow !=0)
                        @for ($i = $itemrow; $i < 5 ; $i++) <tr>

                            <th scope="row">{{$i+1}}<input type="hidden" name="data[{{$i}}][id_description]" value=""></th>
                            <td class="p-1">
                                <select name="data[{{$i}}][description]" id="description" class="form-control description" data-id="{{$i}}">
                                    @foreach ($descriptions as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                <div class="form-group row p-1">
                                    <label for="To" class="col-sm-4 col-form-label">Remark :</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="data[{{$i}}][remark]" class="form-control" id="to">
                                    </div>
                                </div>
                            </td>
                            <td class="p-1">
                                <select name="data[{{$i}}][qty]" id="qty{{$i}}" class="qty">
                                    @for ($qty = 1; $qty < 21; $qty++) <option value="{{$qty}}">{{$qty}}</option>
                                        @endfor
                                </select>
                            </td>
                            <td class="p-1"><input type="text" name="data[{{$i}}][unit_price]" class="unit_price form-control"
                                    id="unit_price{{$i}}" data-id="{{$i}}" min="0" step="0" value="0"></td>
                            <td class="p-1">
                                <select class="form-control currency1" name='data[{{$i}}][currency1]'>
                                    @foreach (trans('cruds.currency') as $key=>$value)
                                    <option value="{{$key}}" >{{$value}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-1">
                                <input type="text" name="data[{{$i}}][amount]" id="amount{{$i}}" class="form-control amount" min="0" step="0"
                                    value="0" readonly>
                            </td>
                            <td class="p-1">
                                <select class="form-control currency" id="currency{{$i}}" data-id="{{$i}}" name="currency">
                                    <option value="">Choose</option>
                                    @foreach (trans('cruds.currency') as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-1 text-center">
                                <input type="checkbox"  value="400" id="vatable{{$i}}" class="cvatabel ml-auto"
                                    vatableamount="0">
                                  
                                   <input type="text" name="data[{{$i}}][vatable]" class="hide vatableamount" id="show{{$i}}" value="0">
                                
                            </td>
                            </tr>
                        
                            @endfor
                    @endif


                    
                </tbody>
            </table>

            <hr>
            <div class="row" style="margin-top:20px">
                <div class="ml-auto col-md-5">
                    <table class="table table-bordered table-hover" id="tab_logic_total">
                        <tbody>
                            <tr>
                                <th class="text-center">Sub Total Amount</th>
                                <td class="text-center"><input type="number" name='Sub_Total_Amount' placeholder='0.00'
                                        class="form-control Sub_Total_Amount" id="Sub_Total_Amount" readonly /></td>
                                <td class="">
                                    <select class="currency form-control">
                                        <option>choose</option>
                                        @foreach (trans('cruds.currency') as $key=>$value)
                                        <option value="{{$key}}" {{($invoice->change_currency == $key)?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">Vatable</th>
                                <td class="text-center"><input type="number" name='Vatable' placeholder='0.00'
                                        class="form-control Vatable" id="Vatable" readonly /></td>
                                <td>

                                    <select class="currency form-control">
                                        <option>choose</option>
                                        @foreach (trans('cruds.currency') as $key=>$value)
                                        <option value="{{$key}}" {{($invoice->change_currency == $key)?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    vat
                                    <select name="vat_percent" id="vat_percent" class="vat_percent">
                                        <option value="5">5 %</option>
                                        <option value="7">7 %</option>
                                    </select>
                                </th>
                                <td class="text-center">
                                    <div class="input-group mb-2 mb-sm-0">
                                        <input type="number" class="form-control vat_amount" name="vat_amount"
                                            id="vat_amount" placeholder="0" readonly>
                                    </div>
                                </td>
                                <td>

                                    <select class="currency form-control">
                                        <option>choose</option>
                                        @foreach (trans('cruds.currency') as $key=>$value)
                                        <option value="{{$key}}" {{($invoice->change_currency == $key)?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">Non - Vatable</th>
                                <td class="text-center"><input type="number" name='nonvatable' placeholder='0.00'
                                        class="form-control nonvatable" id="nonvatable" readonly /></td>
                                <td>

                                    <select class="currency form-control">
                                        <option>choose</option>
                                        @foreach (trans('cruds.currency') as $key=>$value)
                                        <option value="{{$key}}" {{($invoice->change_currency == $key)?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">Grand Total</th>
                                <td class="text-center"><input type="number" name='Grand Total' id="total_amount"
                                        placeholder='0.00' class="form-control" readonly /></td>
                                <td>
                                    <select class="currency form-control" name="totalcurrency">
                                        <option>choose</option>
                                        @foreach (trans('cruds.currency') as $key=>$value)
                                        <option value="{{$key}}" {{($invoice->change_currency == $key)?'selected':''}}>{{$value}}</option>
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
    <form action="{{ route('admin.invoices.deleteform1', $invoice->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger delete_row_btn" type="submit">Delete</button>
    </form>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(document).ready(function(){
        $('.description').on('change',function(){
            var md_expense = $('#md_expense').val()
            var id = $(this).data('id')
            var current_id = $(this).val();
            if (current_id == 2) {
                $('#unit_price'+id).val(md_expense)   
            }else{
                $('#unit_price'+id).val(0) 
            }
        })
    calc()
});

$(function () {
var select = $('.currency');
select.change(function () {
select.not(this).val(this.value);
});

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




function calc()
{
$('#tab_logic tbody tr').each(function(i, element) {
var html = $(this).html();
if(html!='')
{
    
    
 

var qty = parseInt($(this).find('.qty :selected').val());
var unit_price = parseFloat($(this).find('.unit_price').val());
var usd =parseFloat( $('#usd').val());
var thb = parseFloat($('#thb').val());
var mmk =parseFloat( $('#mmk').val() );
var lak =parseFloat( $('#lak').val() );
var md_expense =parseFloat( $('#md_expense').val());
var md_currency =parseFloat( $('#md_currency').val());
var currency=$(this).find('.currency1').val();
var totalcurrency=$(this).find('.currency').val();
var new_amount = 0;
var interperetertotal = 0;
var mdtotal = 0;
var no_vatabel = 0;


if(currency==1 && totalcurrency==1){
 new_amount=qty*unit_price;   
 $(this).find('.amount').val(new_amount.toFixed(2));
 $(this).find('.cvatabel').val(new_amount.toFixed(2));
 if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
 

}
else if(currency==1 && totalcurrency==2){
new_amount=qty*unit_price*thb;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==1 && totalcurrency==3){
new_amount=qty*unit_price*mmk;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==1 && totalcurrency==4){
new_amount=qty*unit_price*lak;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($('.cvatabel').is(':checked')) {
  $(this).find('.vatableamount').val(new_amount.toFixed(2));
}

}
else if(currency==2 && totalcurrency==2){
new_amount=qty*unit_price;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==2 && totalcurrency==1){
new_amount=qty*(unit_price/thb);
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==2 && totalcurrency==3){
new_amount=qty*(unit_price/thb)*mmk;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==2 && totalcurrency==4){
new_amount=qty*(unit_price/thb)*lak;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==3 && totalcurrency==3){
new_amount=qty*unit_price;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==3 && totalcurrency==1){
new_amount=qty*(unit_price/mmk);
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==3 && totalcurrency==2){
new_amount=qty*(unit_price/mmk)*thb;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==3 && totalcurrency==4){
new_amount=qty*(unit_price/mmk)*lak;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==4 && totalcurrency==4){
new_amount=qty*unit_price;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==4 && totalcurrency==1){
new_amount=qty*(unit_price/lak);
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==4 && totalcurrency==2){
new_amount=qty*(unit_price/lak)*thb;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}else{
   
    $(this).find('.vatableamount').val(no_vatabel.toFixed(2));
}
}
else if(currency==4 && totalcurrency==3){
new_amount=qty*(unit_price/lak)*mmk;
$(this).find('.amount').val(new_amount.toFixed(2));
$(this).find('.cvatabel').val(new_amount.toFixed(2));
if ($(this).find('.cvatabel').is(':checked')) {
$(this).find('.vatableamount').val(new_amount.toFixed(2));
}
}




calc_total();
}
});
}

$('#vatable1').on('change', function() {
$('#show1' ).val(this.checked ? this.value : '0');
});
$('#vatable2').on('change', function() {
$('#show2' ).val(this.checked ? this.value : '0');
});
$('#vatable3').on('change', function() {
$('#show3' ).val(this.checked ? this.value : '0');
});
$('#vatable4').on('change', function() {
$('#show4' ).val(this.checked ? this.value : '0');
});
$('#vatable5').on('change', function() {
$('#show5' ).val(this.checked ? this.value : '0');
});
 
$(document).ready(function(){
setInterval(calc_total, 1000);
});

function calc_total()
{
total=0;

$('.amount').each(function() {
total += parseFloat($(this).val());
});
$('#Sub_Total_Amount').val(total.toFixed(2));


vatable = 0;
nonvatable=0;

$('.vatableamount').each(function() {
vatable += parseFloat($(this).val());
});
$('#Vatable').val(vatable.toFixed(2));

vatpercent=$('#vat_percent option:selected').val();
pre_vat_amount=vatable/100
vat_amount=pre_vat_amount*vatpercent;
$('#vat_amount').val(vat_amount.toFixed(2));
nonvatable=parseFloat (total) - parseFloat(vatable);
grand_total=parseFloat (vat_amount) + parseFloat(vatable) + parseFloat(nonvatable);
$('#nonvatable').val(nonvatable.toFixed(2));
$('#total_amount').val(grand_total.toFixed(2));
}



</script>
@endsection
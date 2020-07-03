@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.invoices.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <div class="row">
                <div class="col-6">
                    <div class=" row">
                        <label for="Invoice No" class="col-sm-4 col-form-label">INV.NO :</label>
                        <div class="col-sm-8">
                          <label for="">{{$invoice->invoice_code}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="Ba Ref No" class="col-sm-4 col-form-label">BA REF NO :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice) ? $invoice->medical_info->ba_ref_no : ''}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="Case No" class="col-sm-4 col-form-label">Case No :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice) ? $invoice->medical_info->gcl_case_no : ''}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="Patient Name" class="col-sm-4 col-form-label">Patient Name :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice) ? $invoice->user->family_name.' '.$invoice->user->name : ''}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="MD Expense" class="col-sm-4 col-form-label">MD Expense :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice) ? $invoice->medical_info->medical_amount: 0}}</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class=" row">
                        <label for="INV Date" class="col-sm-4 col-form-label">INV Date:</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice) ? $invoice->invoice_date : ''}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="Insurance" class="col-sm-4 col-form-label">Insurance :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice)&& $invoice->medical_info->insurance ? $invoice->medical_info->insurance->company_name: '-'}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="Assistance" class="col-sm-4 col-form-label">Asstc. Co. :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice)&& $invoice->medical_info->assistance ? $invoice->medical_info->assistance->assistance_name: '-'}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="To" class="col-sm-4 col-form-label">To :</label>
                        <div class="col-sm-8">
                            <label for="">{{$invoice->assistance_to->to_name}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="Treatment Date" class="col-sm-4 col-form-label">Treatment Date :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice) ? $invoice->medical_info->date_of_visit: 0}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="Send On Date" class="col-sm-4 col-form-label">Send On Date :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice) ? $invoice->send_date: ''}}</label>
                        </div>
                    </div>
                    <div class=" row">
                        <label for="Paid On Date" class="col-sm-4 col-form-label">Paid On Date :</label>
                        <div class="col-sm-8">
                          <label for="">{{isset($invoice) ? $invoice->paid_date: ''}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
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
                    @forelse ($invoice->description($invoice->id) as $key=>$item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{App\InvoiceDescription::find($item->invoice_description_id)->description}}</td>
                            <td>{{$item->qty}}</td>
                            <td>{{$item->unit_price}}</td>
                            <td>{{trans('cruds.currency')[$item->currency1]}}</td>
                            <td>{{$item->amount}}</td>
                            <td>{{trans('cruds.currency')[$invoice->change_currency]}}</td>
                            <td><input type="checkbox" {{isset($item)? $item->vatable_status > 0 ?'checked':'' :''}} disabled></td>
                        </tr>
                    @empty
                        <tr>
                        <td colspan="8" class="text-center">No descriptions</p>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="row justify-content-end">
                <div class="col-5">
                    <h5>Calculation</h5>
                    <div class="form-group row">
                        <label for="Sub Total Amount" class="col-sm-4 col-form-label">Subtotal Amount :</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control text-right" id="subtotal_amount" name="subtotal_amount" value="{{$amount->subtotal_amount}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Vatable" class="col-sm-4 col-form-label">Vatable :</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control text-right" id="vatable" name="vatable" value="{{$amount->vatable_amount}}"  readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Vat" class="col-sm-2 col-form-label">Vat :</label>
                        @php
                            $percent = [5,7];
                        @endphp
                        <select name="vat_percent" id="vat_percent" class="col-sm-2 form-control" disabled>
                            <option value="">Choose</option>
                            @foreach ($percent as $key=>$value)
                                <option value="{{$value}}" {{$amount->vatable_percent == $value?'selected':''}}>{{$value}}%</option>
                            @endforeach
                        </select>
                        <div class="col-sm-8">
                        <input type="text" class="form-control text-right" id="vatable_percent_amount" name="vatable_percent_amount" value="{{$amount->calculate_vatable_amount??'0'}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Non Vatable" class="col-sm-4 col-form-label">Non Vatable :</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control text-right" id="non_vatable" name="non_vatable" value="{{$amount->non_vatable??'0'}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Total Amount" class="col-sm-4 col-form-label">Total Amount :</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control text-right" id="total_amount" name="total_amount" value="{{$amount->total_amount??'0'}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
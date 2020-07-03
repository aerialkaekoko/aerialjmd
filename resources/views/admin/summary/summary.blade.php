@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Invoices Summary
        </div>
        <div class="card-body">
           <form action="{{route('admin.summary_download')}}" method="post" target="_blank">  
            @csrf 
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.invoices.fields.invoice_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.reference_no') }}
                        </th>
                        <th>
                            Due Date
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.hospital') }}
                        </th>
                        <th>
                           Status
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.cash_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.insurance') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $key => $invoice)
                        <input type="hidden" name="invoice_id[]" value="{{$invoice->id}}" id="">
                        <tr>
                            <td>
                                {{ $invoice->invoice_code ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->reference_no ?? '' }}
                            </td>
                            <td>
                                {{date('Y-m-d',strtotime($invoice->due_date))}}
                            </td>
                            <td>
                                {{ $invoice->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->medical_info->hospital->name ?? '' }}
                            </td>
                            <td>
                                {!! !empty($invoice->trf_paid==0) ? '<span class="badge badge-danger">Unpaid</span>' : '<span class="badge badge-success">Paid</span>' ?? '' !!}
                            </td>
                            </td>
                            <td>
                                {{ $invoice->medical_info->receive_type == 1 ?"Insurance":"Cash" ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->medical_info->insurance->company_name ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row mt-4">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-md btn-success" name="action" value="summary"><span class="fa fa-download"></span> Summary Download</button>
                    {{--
                    <button type="submit" class="btn btn-md btn-success" name="action" value="detail"><span class="fa fa-download"></span> Detail Download</button>
                    <a href="{{route('admin.summary_detail_excel')}}" class="btn btn-sm btn-success"><span class="fa fa-upload" style="font-size: 14px;"></span>Invoice Detail Download</a> --}}
                </div>
            </div>
           </form>
        </div>
    </div>
@endsection
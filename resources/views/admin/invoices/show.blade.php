@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.invoices.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $invoice->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoices.fields.invoice_code') }}
                        </th>
                        <td>
                            {{ $invoice->invoice_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoices.fields.reference_no') }}
                        </th>
                        <td>
                            {{ $invoice->reference_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>Due Date</th>
                        <td>  {{date('Y-m-d',strtotime($invoice->due_date))}}</td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoices.fields.user') }}
                        </th>
                        <td>
                            {{ $invoice->user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoices.fields.hospital') }}
                        </th>
                        <td>
                            {{ $invoice->medical_info->hospital->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Disease Name
                        </th>
                        <td>
                            {{ $invoice->medical_info->medical->disease_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Cash Type
                        </th>
                        <td>
                            {{ trans('cruds.receive_type')[$invoice->medical_info->receive_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.invoices.fields.insurance') }}
                        </th>
                        <td>
                            {{ $invoice->medical_info->insurance->company_name ?? '-' }}
                        </td>
                    </tr>
            
                    <tr>
                        <th>
                            {{ trans('cruds.medical_informations.fields.medical_amount') }}
                        </th>
                        <td>
                           {{ $invoice->medical_info->medical_amount ?? 0}}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            BA SVF
                        </th>
                        <td>
                           {{ $invoice->ba_svf }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Case Fee
                        </th>
                        <td>
                            {{ $invoice->case_fee }}
                        </td>
                    </tr>

                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
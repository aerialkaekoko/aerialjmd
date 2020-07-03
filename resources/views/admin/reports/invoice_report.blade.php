@extends('layouts.admin')
@section('styles')
    <style>
        .dt-buttons{
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.members.index')}}">{{ trans('cruds.members.title_singular') }} {{ trans('global.list') }}</a>
            </li>
            @can('report_access')
                <li class="nav-item ">
                    <a class="nav-link active" href="{{route('admin.invoice_reports')}}">Invoice Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.patient_reports')}}" >Patient Reports</a>
                </li>
            @endcan
        </ul>
    </div>
    <div class="card-body">
       
        <div class="row my-2">
            <div class="col-md-8 text-right">
                <form action="{{route('admin.invoice_reports')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                                <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Enter From Date" required autocomplete="off" value="{{Request::get('start_date')}}">
                        </div>
                        <div class="col-md-4">
                                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Enter To Date" required autocomplete="off" value="{{Request::get('to_date')}}">
                        </div>
                        <div class="col-md-4 text-left">
                            <button type="submit" class="btn btn-md btn-info"><span class="fa fa-search"></span>Search</button>
                            <a href="{{route('admin.invoice_reports')}}" class="btn btn-md btn-primary"><span class="fa fa-sync"></span></a>
                        </div>
                    </div>
                </form>
            </div>
            @if(auth()->user()->name == 'admin')
            <div class="col-md-2">
                <select class="form-control" id="country">
                    <option value="">All Country</option>
                    @foreach(trans('cruds.countries') as $key=>$value)
                        <option value="{{$key}}" {{ (Request::get('country_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="{{auth()->user()->name == 'admin' ?'col-md-2':'col-md-4'}} text-right">
                    <a href="{{route('admin.invoice_reports_excel')}}?start_date={{Request::get('start_date')}}&to_date={{Request::get('to_date')}}&country_id={{Request::get('country_id')}}" class="btn btn-md btn-success"><span class="fa fa-download"></span> Excel Download</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Insurance">
                <thead>
                    <tr>
                        <th style="width: 12%;">
                            {{ trans('cruds.invoices.fields.invoice_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.reference_no') }}
                        </th>
                        <th style="width: 10%;">
                            InvoiceDate
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.hospital') }}
                        </th>
                        <th>
                           Disease
                        </th>
                        {{--
                        <th style="width: 10%;">
                            {{ trans('cruds.invoices.fields.cash_type') }}
                        </th>
                        --}}
                        <th>
                            {{ trans('cruds.invoices.fields.insurance') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice_reports as $key => $invoice)
                        <tr data-entry-id="{{ $invoice->id }}">
                            <td>
                                {{ $invoice->invoice_code ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->reference_no ?? '' }}
                            </td>
                            <td style="width: 10%;">
                                {{date('Y-m-d',strtotime($invoice->created_at))}}
                            </td>
                            <td>
                                {{ $invoice->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->medical_info->hospital->name ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->medical_info->medical->disease_name ?? '' }}
                            </td>
                            {{--
                            <td style="width: 10%;">
                                {{ trans('cruds.receive_type')[$invoice->medical_info->receive_type] ?? '' }}
                            </td>
                            --}}
                            <td>
                                {{ $invoice->medical_info->insurance->company_name ?? '-' }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(document).ready(function(){
        $('#start_date').datepicker({  dateFormat : 'yy-mm-dd'});
        $('#to_date').datepicker(  {dateFormat : 'yy-mm-dd'});
        $('#country').on('change', function() {
            var url = "{{route('admin.invoice_reports')}}?country_id="+$(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
   });
    $(function (){
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons) 
      $('.datatable-Insurance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endsection
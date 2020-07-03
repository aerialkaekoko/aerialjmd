@extends('layouts.admin')
@section('styles')
    <style>
         th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            margin: 0 auto;
        }
        .dt-buttons{
            display: none;
        }
        table.dataTable {
            margin-top:0 !important;
            margin-bottom:0 !important;
        }
    </style>
@endsection
@section('content')
@if (session('alert'))
    <div class="alert alert-warning">
        {{ session('alert') }}
    </div>
@endif
<div class="card">
    <div class="card-header">
        <h3 style="text-align: left;float: left;">Profit/Loss Report Lists</h3>
    </div>
    {{-- 
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.members.index')}}">{{ trans('cruds.members.title_singular') }} {{ trans('global.list') }}</a>
            </li>
            @can('report_access')
                <li class="nav-item ">
                    <a class="nav-link" href="{{route('admin.invoice_reports')}}">Invoice Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.patient_reports')}}" >Patient Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.profit_reports')}}" >Profit Reports</a>
                </li>
            @endcan
        </ul>
    </div>
    --}}
    <div class="card-body">
        <div class="row my-2">
            <div class="col-md-8 text-right">
                <form action="{{route('admin.profit_reports')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Enter From Date" required autocomplete="off" value="{{Request::get('start_date')}}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Enter To Date" required autocomplete="off" value="{{Request::get('to_date')}}">
                        </div>
                        <div class="col-md-4 text-left">
                            <button type="submit" class="btn btn-md btn-info"><span class="fa fa-search"></span>Search</button>
                            <a href="{{route('admin.profit_reports')}}" class="btn btn-md btn-primary"><span class="fa fa-sync"></span></a>
                        </div>
                    </div>
                </form>
            </div>
            @if(auth()->user()->name == 'admin')
            {{--
            <div class="col-md-2">
                <select class="form-control" id="country">
                    <option value="">All Country</option>
                    @foreach(trans('cruds.countries') as $key=>$value)
                        <option value="{{$key}}" {{ (Request::get('country_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            --}}
            <div class="col-md-2">
                <select class="form-control" id="desk" style="font-size: 15px;">
                    <option value="">All Desk</option>
                        @foreach(trans('cruds.desk') as $key=>$value)
                        <option value="{{$key}}" {{ (Request::get('desk_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                        @endforeach
                </select>
            </div>
            @endif
            <div class="{{auth()->user()->name == 'admin'?'col-md-2':'col-md-4'}} text-right">
                <!-- <button type="button" class="btn btn-md btn-success" id="btn_export_profille"><span class="fa fa-download"></span>Profit Download</button> -->
                <!-- <a href="#" class="btn btn-sm btn-success"><span class="fa fa-download"></span> Profit Download</a> -->
                <a href="{{route('admin.profit_reports_excel')}}?start_date={{Request::get('start_date')}}&to_date={{Request::get('to_date')}}&country_id={{Request::get('country_id')}}&desk_id={{Request::get('desk_id')}}" class="btn btn-sm btn-success"><span class="fa fa-download"></span> Profit Download</a>
            </div>
        </div>
        <div class="">
            <table class=" table table-bordered  datatable datatable-Insurance">
                <thead>
                    <tr>
                        <th>No.</th>                        
                        <th>
                            Invoice Date
                        </th>
                        <th>
                            Ref No.
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.hospital') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.insurance') }}
                        </th>
                         <th>
                            {{ trans('cruds.invoices.fields.assistance') }}
                        </th>
                        <th>MD Exp.</th>
                        <th>
                            BA SVF
                        </th>
                        <th>
                            Case Fee
                        </th>
                        <th>
                            KB
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $ba_svf = 0;
                    @endphp
                    @foreach($profit_reports as $key => $profit)
                        <tr data-entry-id="{{ $profit->id }}">
                            <td>
                                {{$key+1}}
                            </td>
                            <td>
                                {{date('d-m-Y',strtotime($profit->invoice_date))}}
                            </td>
                            <td>
                                {{ !empty($profit->medical_info->ba_ref_no) ? $profit->medical_info->ba_ref_no: '-' ?? '' }}
                            </td>
                            <td>
                                {{ $profit->user->family_name ?? '' }} {{ $profit->user->name ?? '' }}
                            </td>                            
                            <td>
                                {{ !empty($profit->medical_info->hospital->name) ? $profit->medical_info->hospital->name : "-" ?? '' }}
                            </td>
                            
                            <td>
                                {{ !empty($profit->medical_info->insurance_id) ? $profit->medical_info->insurance->company_name : '-' ?? '' }}
                            </td>
                            <td>
                             {{ !empty($profit->medical_info->assistance_id) ? $profit->medical_info->assistance->assistance_name : '-' ?? '' }}
                         </td>
                            <td>
                             {{ !empty($profit->medical_info->medical_amount2) ? $profit->medical_info->medical_amount2 : "0.00" ?? '' }}
                             
                            </td>
                            <td>
                                @php
                                    $ba_svf = 0;
                                    foreach ($profit->description($profit->id) as $desc) {
                                        if($desc->invoice_description_id==1 || $desc->invoice_description_id==2 || $desc->invoice_description_id==3 || $desc->invoice_description_id==5 || $desc->invoice_description_id==6 || $desc->invoice_description_id==8){
                                            $ba_svf +=$desc->amount;
                                        }
                                    }
                                @endphp
                                {{ $ba_svf ?? ''}}                                
                            </td>
                            <td>
                                @php
                                    $case_fee = 0;
                                    foreach ($profit->description($profit->id) as $desc) {
                                        if($desc->invoice_description_id==4){
                                            $case_fee =$desc->amount;
                                        }
                                    }
                                @endphp
                                {{ $case_fee ?? ''}} 
                                {{--
                                @foreach($profit->description($profit->id) as $key =>$desc)
                                    @if($desc->invoice_description_id==4)
                                    {{ $desc->amount ?? '-' }}
                                    @endif
                                @endforeach
                                --}}
                            </td>
                            <td>
                            {{--
                               {{ !empty($profit->medical_info->kb) ? $profit->medical_info->kb : "0.00" ?? '' }}
                               --}}
                               <input type="text" name="kb" id="kb{{$profit->medical_info->id}}" class="kb" value="{{ !empty($profit->medical_info->kb) ? $profit->medical_info->kb : "0.00" ?? '' }}"
                                data-id="{{$profit->medical_info->id}}">
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>
</div>


<form action="{{route('admin.profit_reports_excel')}}" method="post" id="frmExportProfit">
    @csrf
    <input type="hidden" name="start_date" id="hidden_start_date">
    <input type="hidden" name="end_date" id="hidden_end_date">
</form>

@endsection
@section('scripts')
@parent
<script>
   $(document).ready(function(){
        $('#start_date').datepicker({  dateFormat : 'yy-mm-dd'});
        $('#to_date').datepicker(  {dateFormat : 'yy-mm-dd'});
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
         $.extend(true, $.fn.dataTable.defaults, {
            order: [[ 1, 'desc' ]],
            pageLength: 100,
          });
          $('.datatable-Insurance:not(.ajaxTable)').DataTable({
               buttons: dtButtons ,
               columnDefs: [{
                    className: '',
                    targets: 0
                }],
               scrollX:        true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 1,
                    rightColumns: 3
                }
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            $('.kb').on('keypress',function(e){
                if (e.which === 13) {
                    var id = $(this).data('id');
                    var next_id = id+1;
                    var value = $(this).val();
                    $.ajax({
                        method : "POST",
                        url : '/admin/profit_reports/change_kb/'+id,
                        data : {
                            "_token": "{{ csrf_token() }}",
                            kb : value
                            },
                        success : function(data){
                            if (data.success) {
                                console.log('Successfully');
                                $(e.target)
                                .closest('tr')
                                .nextAll('tr:not(.group)')
                                .first()
                                .find('.kb')
                                .focus();
                            }
                        }
                    })
                }
        })
   });


   $( '#btn_export_profille' ).click(function(){

        $( '#hidden_start_date' ).val( $( '#start_date' ).val() );
        $( '#hidden_end_date' ).val( $( '#to_date' ).val() );
        $( '#frmExportProfit' ).submit();
   });

   $('#country').on('change', function() {
        var url = "{{route('admin.profit_reports')}}?country_id="+$(this).val();
            if (url) {
                window.location = url;
            }
        return false;
    });

    $('#desk').on('change', function() {
        var url = "{{route('admin.profit_reports')}}?desk_id="+$(this).val();
        if (url) {
            window.location = url;
        }
        return false;
    });
    $('.kb').on('keypress',function(e){
    if (e.which === 13) {
    var id = $(this).data('id');
    var next_id = id+1;
    var value = $(this).val();
    $.ajax({
    method : "POST",
    url : '/admin/patient_reports/change_kb/'+id,
    data : {
    "_token": "{{ csrf_token() }}",
    kb : value
    },
    success : function(data){
    if (data.success) {
    console.log('Successfully');
    $(e.target)
    .closest('tr')
    .nextAll('tr:not(.group)')
    .first()
    .find('.kb')
    .focus();
    }
    }
    })
    }
    })
</script>
@endsection
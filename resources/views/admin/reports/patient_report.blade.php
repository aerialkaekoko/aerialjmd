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
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.members.index')}}">{{ trans('cruds.members.title_singular') }} {{ trans('global.list') }}</a>
            </li>
            @can('report_access')
               <!--
                <li class="nav-item ">
                    <a class="nav-link " href="{{route('admin.invoice_reports')}}">Invoice Reports</a>
                </li>
                -->
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.patient_reports')}}" >Patient Reports</a>
                </li>
            @endcan
        </ul>
    </div>
    <div class="card-body">
       
        <div class="row my-2">
            <div class="{{auth()->user()->name == 'admin'?'col-md-5':'col-md-6'}} col-sm-12 text-right">
                <form action="{{route('admin.patient_reports')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="start_date" id="start_date" class="form-control" placeholder="From Date" required autocomplete="off" value="{{Request::get('start_date')}}" style="font-size: 15px;">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" required autocomplete="off" value="{{Request::get('to_date')}}" style="font-size: 15px;">
                        </div>
                        <div class="col-md-4 text-left">
                            <button type="submit" class="btn btn-sm btn-info"><span class="fa fa-search" style="font-size: 12px;"></span>Search</button>
                            <a href="{{route('admin.patient_reports')}}" class="btn btn-sm btn-primary"><span class="fa fa-sync" style="font-size: 12px;"></span></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"> 
            <div class="row"> 
            @if(auth()->user()->name == 'admin')
                <div class="col-md-6">
                    <select class="form-control" id="country" style="font-size: 15px;">
                        <option value="">AllCountry</option>
                        @foreach(trans('cruds.countries') as $key=>$value)
                            <option value="{{$key}}" {{ (Request::get('country_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-control" id="desk" style="font-size: 15px;">
                        <option value="">AllDesk</option>
                            @foreach(trans('cruds.desk') as $key=>$value)
                            <option value="{{$key}}" {{ (Request::get('desk_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                    </select>
                </div>
            @endif
        </div>
           </div>
            <div class="{{auth()->user()->name == 'admin'?'col-md-4':'col-md-6'}} col-sm-12 text-right" id="">
                {{--
                <a href="{{asset('/excelfile/medical_info_format.xlsx')}}" class="btn btn-sm btn-success"><span class="fa fa-download" style="font-size: 14px;"></span> Import File</a>
                <button class="btn btn-sm btn-success"  data-toggle="modal" data-target="#importBtn"><span class="fa fa-download" style="font-size: 14px;"></span> Excel Import</button>
                --}}
                <a href="{{route('admin.patient_reports_excel')}}?start_date={{Request::get('start_date')}}&to_date={{Request::get('to_date')}}&country_id={{Request::get('country_id')}}&desk_id={{Request::get('desk_id')}}" class="btn btn-sm btn-success" id="search_result"><span class="fa fa-upload" style="font-size: 14px;"></span>Excel Export</a>
            </div>
        </div>
        <div>
            <table class=" table table-bordered  datatable datatable-Insurance patient_reports" style="overflow-x: hidden;">

                <thead>
                    <tr>
                        <th style="width: 10px;">
                            No.
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.reference_no') }}
                        </th>
                        <th>
                            性別
                        </th>                       
                        <th>
                            名前
                        </th>
                        <th>
                            初診・再診
                        </th>
                        <th>
                            IPD/OPD
                        </th>
                        <th>
                            Hospital
                        </th>
                        <th>
                            PatientNo.
                        </th>
                        <th>
                            InsuranceInfo
                        </th>
                        <th>
                            {{ trans('cruds.invoices.fields.insurance') }}
                        </th>                        
                        <th>
                           Assistance
                        </th>
                        <th>
                            GCL No.
                        </th>
                        <th>
                           Sympton
                        </th>
                        <th>
                            治療費合計
                        </th>
                        <th>
                            KB
                        </th>
                        <th>
                            通訳者
                        </th>
                        <th>
                            平日または祝日対応
                        </th>
                        <th>
                            対応形式
                        </th>
                        <th>
                            Service Time
                        </th>
                        <th>
                            Document Date
                        </th>
                        <th>
                            -
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patient_reports as $key => $item)

                        <tr data-entry-id="{{ $item->id }}" id="{{ $item->id }}">
                            <td style="text-align: center;">
                                {{$key+1}}
                            </td>
                            <td>
                                {{ !empty($item->date_of_visit) ? $item->date_of_visit: '-' ?? '' }}
                            </td>                          
                            <td>
                                {{ $item->ba_ref_no ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                @if(isset($item->user->gender))
                                    {{$item->user->gender == 'male' ? 'M' : 'F'}}
                                    @else
                                    -
                                @endif
                            </td>                    
                            <td style="width: 10%;">
                                {{ $item->user->family_name ?? '' }} {{ $item->user->name ?? '' }}
                            </td>
                            <td>
                                 {{ !empty($item->re_exam ) ? $item->re_exam==1 ? "再診" : '初診' : '-' ?? '' }}
                                {{--
                                {{ !empty($item->the_first_visit_date) ? $item->the_first_visit_date: '-' ?? '' }}
                                --}}
                            </td>
                            <td>
                                {{ !empty($item->opd_ipd) ? $item->opd_ipd == 1 ? "IPD" : "OPD" : '-' ?? '' }}
                            </td>
                            <td>
                                {{ !empty($item->hospital_id) ? $item->hospital->name: '-' ?? '' }}</td>
                            <td>
                                {{ !empty($item->user->member_no) ? $item->user->member_no: '-' ?? '' }}
                            </td>
                            <td>
                                {{App\UserInsurance::TYPE[$item->payment_type]}}
                            </td>
                            <td>                               
                                {{ $item->insurance_id ? $item->insurance->company_name : "-"  ?? '' }}
                            </td>                                                       
                            <td>
                                {{ !empty($item->assistance_id) ? $item->assistance->assistance_name : '-' ?? '' }}
                            </td>
                            <td>
                                {{ !empty($item->gcl_case_no) ? $item->gcl_case_no: '-' ?? '' }}
                            </td>
                            <td>
                                {{ !empty($item->symptons) ? $item->symptons: '-' ?? '' }}
                            </td>
                            <td>
                               {{ !empty($item->medical_amount2) ? $item->medical_amount2 : "0.00" ?? '' }}
                            </td>
                            <td>
                                <input type="text" name="kb" id="kb{{$item->id}}" class="kb" value="{{ !empty($item->kb) ? $item->kb : "0.00" ?? '' }}" data-id="{{$item->id}}">
                            </td>
                            <td>
                                {{ !empty($item->translator_name) ? $item->translator_name: '-' ?? '' }}
                            </td>
                             <td>
                                {{ !empty($item->weekday_end) ? $item->weekday_end==1 ? "WeekDay" : "WeekEnd" : "-" ?? '' }}
                            </td>
                            <td>
                                {{ !empty($item->side_response) ? $item->side_response==1 ? "OnSite" : "Phone" : "-" ?? '' }}
                            </td>
                            <td>
                                @php
                                    $all_differ = strtotime("00:00");
                                    $converted_time = 0;
                                foreach ($item->services as $service){
                                    $service_in = strtotime($service->intime);
                                    $service_out = strtotime($service->outtime);
                                    $service_differ = ($service_out - $service_in) / 60;                                 

                                    $all_differ +=$service_differ;
                                    $converted_time = date('H:i', mktime(0,$all_differ));
                                    
                                }
                                @endphp
                                {{ $converted_time ? $converted_time : '-' ?? ''}} mins
                            </td>                            
                            <td>
                                {{ !empty($item->document_date) ? date('d-m-Y',strtotime($item->document_date)) : "-" ?? '' }}
                            </td>
                                                      
                            <td>
                                <div class="dropdown show">
                                    <a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-file-invoice"></i>
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{route('admin.invoices.createform1')}}?invoices=[{{$item->id}}]">Form 1</a>
                                      <a class="dropdown-item" href="{{route('admin.invoices.createform2')}}?invoices=[{{$item->id}}]">Form 2</a>
                                    </div>
                                  </div>
                                {{-- @php
                                    $current_user = Auth::user();
                                    $permission_btn =false;
                                        if($current_user->name == 'admin' || $current_user->country == $item->hospital->country){
                                            $permission_btn = true;
                                        }else{
                                            $permission_btn = false;
                                        }
                                @endphp
                                @if($item->status == 0)
                                    @can('invoice_create')
                                        <a class="btn btn-xs btn-success {{ $permission_btn == true? '':'disabled'}}" href="#" data-toggle="tooltip" data-placement="top" title="Create Invoice" >
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                        <a class="btn btn-xs btn-success {{ $permission_btn == true? '':'disabled'}}" href="#" data-toggle="tooltip" data-placement="top" title="Create Invoice" >
                                            <i class="fas fa-file-invoice"></i>
                                        </a> 
                                        <form action="{{route('admin.invoices.createform1')}}" method="get" style="display:inline;">
                                            <input type="hidden" name="invoices" id="invoices" class="invoices" value="[{{$item->id}}]">
                                            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Create Invoice" ><i class="fas fa-file-invoice"></i></button>
                                        </form>
                                    @endcan
                                @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>
</div>
<!-- import data modal -->
<form action="{{ route('admin.import')}}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="modal fade" id="importBtn" tabindex="-1" role="dialog" aria-labelledby="importBtn" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <input type="file" name="file" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Import</button>
          </div>
        </div>
      </div>
    </div>
</form>

@endsection
@section('scripts')
@parent
<script>
   $(document).ready(function(){
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
     $.extend(true, $.fn.dataTable.defaults, {
        // order: [[ 1, 'desc' ]],
        pageLength: 25,
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
                rightColumns: 4
            }
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
        $('#start_date').datepicker({  dateFormat : 'yy-mm-dd'});
        $('#to_date').datepicker(  {dateFormat : 'yy-mm-dd'});
        $('#country').on('change', function() {
            var url = "{{route('admin.patient_reports')}}?country_id="+$(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
        $('#desk').on('change', function() {
        var url = "{{route('admin.patient_reports')}}?desk_id="+$(this).val();
        if (url) {
            window.location = url;
        }
        return false;
        
    });
    $('.datatable-Insurance').on('search.dt', function() {
    var search = $('.dataTables_filter input').val();
    var arr= [];
    $(".datatable-Insurance tr").each(function() {
    arr.push(this.id);
    });
    arr = arr.filter(item => item);
    arr=JSON.stringify(arr);
    console.log(arr);
    
    var url = "{{route('admin.patient_reports_excel')}}?start_date={{Request::get('start_date')}}&to_date={{Request::get('to_date')}}&country_id={{Request::get('country_id')}}&desk_id={{Request::get('desk_id')}}&search="+arr;
    console.log(arr);
    
    $('#search_result').attr('href', url );
    
    
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
   });

</script>
@endsection
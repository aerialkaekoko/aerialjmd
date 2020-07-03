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
@can('invoice_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.invoices.createlist") }}">
            {{ trans('global.create') }} {{ trans('cruds.invoices.title_singular') }}
        </a>
        
        <button type="button" class="btn btn-success" id="edit-item" data-item-id="1" disabled>
            Multi Edit
        </button>
    </div>
</div>
@endcan
@if (session('alert'))
    <div class="alert alert-warning">
        {{ session('alert') }}
    </div>
@endif
<div class="card">
    <div class="card-header">
            {{ trans('cruds.invoices.title_singular') }} {{ trans('global.list') }}
    </div>
    <div class="card-body">
        <div class="row my-2">
            <div class="col-md-5 text-right">
                <form action="{{route('admin.invoices.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                                <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Enter From Date" required autocomplete="off" value="{{Request::get('start_date')}}">
                        </div>
                        <div class="col-md-4">
                                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Enter To Date" required autocomplete="off" value="{{Request::get('to_date')}}">
                        </div>
                        <div class="col-md-4 text-left">
                            <button type="submit" class="btn btn-sm btn-info" style="font-size: 14px;"><span class="fa fa-search"></span>Search</button>
                            <a href="{{route('admin.invoices.index')}}" class="btn btn-sm btn-primary"><span class="fa fa-sync"></span></a>
                        </div>
                    </div>
                </form>
            </div>
            @if(auth()->user()->name == 'admin')
                <div class="col-md-1.5">
                    <select class="form-control" id="country">
                        <option value="">All Country</option>
                        @foreach(trans('cruds.countries') as $key=>$value)
                            <option value="{{$key}}" {{ (Request::get('country_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                        @endforeach
                    </select>

                </div>
            @endif
            <div class="{{auth()->user()->name == 'admin'?'col-md-2':'col-md-4'}} text-right" style="margin-right: -30px;">
                
                    <a href="{{route('admin.invoice_reports_excel')}}?start_date={{Request::post('start_date')}}&to_date={{Request::post('to_date')}}&country_id={{Request::post('country_id')}}" class="btn btn-sm btn-success search_result" id="search_result"><span class="fa fa-download"></span>Report Download</a>
            </div>
            <div class="{{auth()->user()->name == 'admin'?'col-md-2':'col-md-4'}} text-right">
                    <a href="{{route('admin.summary_detail_excel')}}?start_date={{Request::get('start_date')}}&to_date={{Request::get('to_date')}}&country_id={{Request::get('country_id')}}" class="btn btn-sm btn-success search_result" ><span class="fa fa-download"></span>Detail Download</a>
            </div>
            {{-- <div class="{{auth()->user()->name == 'admin'?'col-md-2':'col-md-4'}} text-right" style="margin-right: -30px;">
                <input type="hidden" name="h_invoice" id="h_invoice" >
                <a href="{{route('admin.summary_reports_excel')}}?start_date={{Request::get('start_date')}}&to_date={{Request::get('to_date')}}&country_id={{Request::get('country_id')}}" class="btn btn-sm btn-success"><span class="fa fa-download"></span>Summary Download</a>
            </div>
            --}}
            <div class='col-md-1.5'>
                <form action="{{route('admin.summary_reports_excel')}}?start_date={{Request::get('start_date')}}&to_date={{Request::get('to_date')}}&country_id={{Request::get('country_id')}}" method="post" style="display:inline;" >
                    @csrf
                    <input type="hidden" name="h_invoice" id="h_invoice" >
                    <input type="submit" value="Summary Download" id="summaryPreview" class="btn btn-md btn-success">          
                </form>
            </div>
            
        </div>

        <div class="">
            <table class=" table table-bordered  datatable datatable-Insurance">
                <thead>
                    <tr>
                        <th></th>
                        <th>
                            Invoice No.
                        </th>
                        <th style="width: 10%;">
                            BA Ref No.
                        </th>
                        <th>Insurance</th>
                        <th>Assistance Company</th>
                        <th>AGT Ref No</th>
                        <th>Patient Name</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Sent</th>
                        <th>Paid/Unpaid</th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $key => $invoice)
                        
             
                        <tr data-entry-id="{{ $invoice->id }}" id="{{ $invoice->id }}">
                           
                            <td>
                                <input type="checkbox" class="chk" data-entry-id="{{ $invoice->id }}">
                            </td>
                            
                            <td>
                                {{ !empty($invoice->invoice_code) ? $invoice->invoice_code: '-' ?? '' }}
                            </td>
                            <td>
                                {{ !empty($invoice->medical_info->ba_ref_no) ? $invoice->medical_info->ba_ref_no: '-' ?? '' }}
                            </td>
                            <td style="width: 10%;">
                                {{ !empty($invoice->medical_info->insurance_id) ? $invoice->medical_info->insurance->company_name : '-' ?? '' }}
                            </td>                            
                            <td>
                                {{ !empty($invoice->medical_info->assistance_id) ? $invoice->medical_info->assistance->assistance_name : '-' ?? '' }}
                            </td>
                            <td>
                                {{ !empty($invoice->medical_info->gcl_case_no) ? $invoice->medical_info->gcl_case_no: '-' ?? '' }}
                            </td>
                            <td>
                                {{ !empty($invoice->medical_info->patient_id) ? $invoice->user->family_name : '-' ?? '' }} {{ !empty($invoice->medical_info->patient_id) ? $invoice->user->name : '-' ?? '' }}
                            </td>
                            @if($invoice->change_currency==1)
                                <td> {{ "USD" }} </td>
                            @elseif($invoice->change_currency==2)
                                <td>{{ "Baht" }}</td>
                            @elseif($invoice->change_currency==3)
                                <td>{{ "MMK" }}</td>
                            @else
                                <td>{{ "LAK" }}</td>
                            @endif                                
                            <td> 
                                <!-- {{ !empty($invoice->medical_info->medical_amount) ? $invoice->medical_info->medical_amount : '-' ?? '' }} -->
                                {{ $invoice->amount($invoice->invoice_code)->total_amount ?? ''}}
                            </td>
                            <td>
                                 {{ !empty($invoice->invoice_date) ? date('d-m-Y',strtotime($invoice->invoice_date)) : '-' ?? '' }}
                            </td>
                            <td>
                               {{ !empty($invoice->send_date) ? date('d-m-Y',strtotime($invoice->send_date)) : '-' ?? '' }}
                            </td>
                            <td>
                                {{ !empty($invoice->trf_paid==0) ? "Unpaid" : 'Paid' ?? '' }}
                            </td>
                            <td>
                                @can('invoice_show')
                                  @if($invoice->form_status==1)
                                    <a class="btn btn-xs btn-primary" href="{{route('admin.invoices.show1',$invoice->id)}}" data-toggle="tooltip" data-placement="top" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                  @else 
                                    <a class="btn btn-xs btn-primary" href="{{route('admin.invoices.show2',$invoice->id)}}" data-toggle="tooltip"
                                        data-placement="top" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                   @endif  
                                @endcan

                                @can('invoice_edit')
                                  @if($invoice->form_status==1)
                                    <a class="btn btn-xs btn-info" href="{{route('admin.invoices.editform1',$invoice->id)}}" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                   @else
                                   <a class="btn btn-xs btn-info" href="{{route('admin.invoices.editform2',$invoice->id)}}" data-toggle="tooltip"
                                    data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                   </a>

                                   @endif 
                                @endcan

                                {{-- @can('invoice_delete')
                                    <form action="#" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </form>
                                @endcan --}}
                                @can('invoice_download')
                                <a href="/admin/invoices/downloadpdf/{{$invoice->id}}" class="btn btn-xs btn-warning" target="_blank"><span class="fa fa-download" title="Download"></span></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>
</div>
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-modal-label">Edit Multi Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body" id="attachment-body-content">
            <form action="{{ route("admin.multi_update") }}" method="POST" enctype="multipart/form-data" id="multi_update">
                @csrf
                @method('POST')
                <input type="hidden" name="m_invoice" id="m_invoice" >
                  
                <div class="form-group">
                    <label class="col-form-label" for="modal-input-name">Trf/Paid</label>
                    <select class="form-control" id="trf_paid" name="trf_paid">
                        <option value="0">Unpaid</option>
                        <option value="1">Paid</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="Invoice Code">Sent Date *:</label>
                            <input type="date" class="form-control" name="send_date" id="send_date" value=" {{ !empty($invoice->send_date) ? date('Y-m-d',strtotime($invoice->send_date)) : date('Y-m-d') ?? '' }}" placeholder="Enter Sent Date" autocomplete="off">
                            <span class="error_send_date text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <input id="update_button" type="" value="Update" class="btn btn-sm btn-primary">
                    </div>
                </div>
            </form>
        </div>
  </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
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
                    leftColumns: 0,
                    rightColumns: 3
                }
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        var arrData = [];
        $(".datatable-Insurance input:checkbox").change(function() {
            var ischecked= $(this).is(':checked');
            var checkCount =$(".chk:checked").length;
            if (checkCount > 0) {
                $('#summaryPreview').show();
            }else{
                $('#summaryPreview').hide();
            }
            if(ischecked){
                //alert('hello');
                $("#edit-item").attr("disabled", !this.checked);
                arrData.push($(this).data('entry-id'));
            }else{
                if ($('.chk').filter(':checked').length < 1){

                    $("#edit-item").attr('disabled',true);

                }
                
                arrData.splice( arrData.indexOf($(this).data('entry-id')), 1 );
            }
            console.log(arrData);
            $('#h_invoice').val(arrData);
            $('#m_invoice').val(arrData);
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

        var url = "{{route('admin.invoice_reports_excel')}}?search="+arr;
        console.log(arr);

         $('#search_result').attr('href',  url );
         
       
        return false; 
        });
      
    });

    $(document).ready(function(){
        $('#start_date').datepicker({  dateFormat : 'yy-mm-dd'});
        $('#to_date').datepicker(  {dateFormat : 'yy-mm-dd'});
        $('#country').on('change', function() {
            var url = "{{route('admin.invoices.index')}}?country_id="+$(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
   });
</script>

<script>

$(document).ready(function() {
  $(document).on('click', "#edit-item", function() {
    $(this).addClass('edit-item-trigger-clicked');
    var options = {
      'backdrop': 'static'
    };
    $('#edit-modal').modal(options)
  })

  $(document).on('click', "#update_button", function() {
    $('#multi_update').submit();
  })

  // on modal show
  $('#edit-modal').on('show.bs.modal', function() {
    var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
    var row = el.closest(".data-row");

    // get the data
    var id = el.data('item-id');
    var name = row.children(".name").text();
    var receive_amount = row.children(".receive_amount").text();

    // fill the data in the input fields
    $("#modal-input-id").val(id);
    $("#modal-input-name").val(name);
    $("#receive_amount").val(receive_amount);

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})

</script>

@endsection
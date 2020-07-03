@can('admin_dashboard')
@extends('layouts.admin') 
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
                @can('chart_access')
                    <div class="card-body">
                        @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="row">

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3> {{$users->count()}}</h3>

                                        <p>USERS</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa-fw fas fa-user"></i>
                                    </div>
                                    <a href="admin/users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3> {{$members->count()}}</h3>

                                        <p>MEMBERS</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                    <a href="/admin/members" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3> {{$invoices->count()}}</h3>

                                        <p>INVOICES</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <a href="admin/invoices" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3> {{$hospitals->count()}}</h3>

                                        <p>HOSPITALS</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-hospital"></i>
                                    </div>
                                    <a href="admin/hospitls" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->

                            <div class="{{ $chart1->options['column_class'] }}">
                                <h3>{!! $chart1->options['chart_title'] !!}</h3>
                                {!! $chart1->renderHtml() !!}
                            </div>
                            <div class="col-md-4">
                                <h3>Income & Expense</h3>
                                <canvas id="income_expense" width="400" height="400"></canvas>
                            </div>
                            
                            {{-- Widget - latest entries 
                            {{--
                            <div class="col-md-12">
                                <h3>Latest Invoices</h3>
                                <table class=" table table-bordered " width="100%">
                                    <thead>
                                        <tr>
                                            <th width="10">
                                            </th>
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
                                                Disease
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
                                        <tr data-entry-id="{{ $invoice->id }}">
                                            <td>
                                            </td>
                                            <td>
                                                {{ $invoice->invoice_code ?? '' }}
                                            </td>
                                            <td>
                                                @can('invoice_show') 
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.invoices.show', $invoice->id) }}">
                                                        {{ !empty($invoice->medical_info->ba_ref_no) ? $invoice->medical_info->ba_ref_no: '-' ?? '' }}
                                                    </a> 
                                                    @endcan

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
                                                {{ $invoice->medical_info->medical->disease_name ?? '' }}
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

                            </div>
                            --}}
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <h3 style="margin: 4px 14px;color: red">Booking Patient</h3>
                    <div class="response"></div>
                    <div id='calendar'>                        
                    </div>  
                </div>
            </div>
        </div>
        
        
    </div>
</div>

@endsection 
@section('scripts') 
@parent
<script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
<!-- <script src="https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
<script>
  $(document).ready(function () {
    var ctx = $('#income_expense');
    data = {
    datasets: [{
        data: [10, 20],
        backgroundColor: ['green','red']
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Income',
        'Expense',
    ]
};
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data
    });
         
        var SITEURL = "{{url('/')}}";
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
 
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: SITEURL + "fullcalendar",
            displayEventTime: true,
            editable: true,
            events : [
                    
                ],
            eventRender: function(event, element) {
                element.attr('title', event.description);
                var el = element.html();
    element.html("<div style='width:90%;float:left;'>" +  el + "</div><div style='text-align:right;' class='close'><span class='glyphicon glyphicon-trash'></span></div>");

                // element.css("backgroundColor", "red");
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                // var title = prompt('Event Title:'); 
                if (title) {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
 
                    $.ajax({
                        url: SITEURL + "fullcalendar/create",
                        data: 'title=' + title + '&amp;start=' + start + '&amp;end=' + end,
                        type: "POST",
                        success: function (data) {
                            displayMessage("Added Successfully");
                        }
                    });
                    calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                    true
                            );
                }
                calendar.fullCalendar('unselect');
            },
             
            eventDrop: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: SITEURL + 'fullcalendar/update',
                        data: 'title=' + event.title + '&amp;start=' + start + '&amp;end=' + end + '&amp;id=' + event.id,
                    type: "POST",
                        success: function (response) {
                        displayMessage("Updated Successfully");
                    }
                });
            },
            
        });
  });
 
  function displayMessage(message) {
    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
{!! $chart1->renderJs() !!}



@endsection

@endcan

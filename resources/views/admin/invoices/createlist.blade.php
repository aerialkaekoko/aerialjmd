@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">Medical Information List</div>
    <div class="card-body">
        <div class="row justify-content-end">
            {{-- <div class="col-4">
                <select name="patient_id" id="patient_id" class="form-control select2">
                    @foreach ($patients as $item)
                        <option value="{{$item->id}}" {{ (Request::get('patient_id') == $item->id) ? 'selected' : '' }}>{{$item->family_name}} {{$item->name}}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>
        <div class="text-right mt-2 mb-2">
            <form action="{{route('admin.invoices.createform1')}}" method="get" style="display:inline;">
                <input type="hidden" name="invoices" id="invoices" class="invoices" >
                <input type="submit" value="Form 1" id="form1" class="btn btn-md btn-success" style="display: none;">
            </form>
            <form action="{{route('admin.invoices.createform2')}}" method="get" style="display:inline;">
                <input type="hidden" name="invoices" id="invoices" class="invoices">
                <input type="submit" value="Form 2" id="form2" class="btn btn-md btn-success" style="display: none;">
            </form>
          </div>
        <table class="table table-bordered mt-1 MDInfo">
            <thead>
              <tr>
                <th scope="col">
                    {{-- <input type="checkbox" name="" id="selectall"> --}}
                </th>
                <th scope="col">Patient Name</th>
                <th scope="col">Insurance</th>
                <th scope="col">Assistance</th>
                <th scope="col">BA Ref No</th>
                <th scope="col">MD Expense</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <th><input type="checkbox" name="" id="" value="{{$item->id}}" class="chk" data-insurance="{{$item->insurance_id}}" data-assistance="{{$item->assistance_id}}"></th>
                        <td>{{$item->user->family_name??''}} {{$item->user->name??''}}</td>
                        <td>{{ $item->insurance_id ? $item->insurance->company_name : "-"  ?? '' }}</td>
                        <td>{{ !empty($item->assistance_id) ? $item->assistance->assistance_name : '-' ?? '' }}</td>
                        <td>{{$item->ba_ref_no}}</td>
                        <td>{{$item->medical_amount}}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
     $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


    $.extend(true, $.fn.dataTable.defaults, {
        pageLength: 100,
    });
    $('.MDInfo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
    $('#patient_id').on('change', function() {
        var url = "{{route('admin.invoices.createlist')}}?patient_id="+$(this).val();
        if (url) {
            window.location = url;
        }
        return false;
    });
    $('#selectall').click(
        function() {
            $('.chk').prop('checked', true);
        },
        function() {
            $('.chk').prop('checked', false);
        }
    );
    var arrData = [];
    var insuranceData = [];
    var assistanceData = [];
    $(".MDInfo input:checkbox").change(function() {
        var ischecked= $(this).is(':checked');
        var checkCount =$(".chk:checked").length;
        var insurance = $(this).data('insurance');
        if (checkCount > 0) {
            $('#form1').show();
            $('#form2').show();
            if (checkCount >1 ) {
                $('#form1').hide();
            }
        }else{
            $('#form1').hide();
            $('#form2').hide();
        }
        if(ischecked){
            arrData.push($(this).val());
            if(insuranceData.includes(insurance)){
                console.log('yes')
            }else{
                console.log('not')
            }
        }else{
            arrData.splice( arrData.indexOf($(this).val()), 1 );
        }
        $('.invoices').val(JSON.stringify(arrData));
    }); 
    
</script>
@endsection
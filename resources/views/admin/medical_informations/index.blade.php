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
<div class="card">
    <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.members.index') }}">Member Lists</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.members.edit',$user_id)}}">Edit Member</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.user-insurances.create',['user_id'=>$user_id,'type'=>'edit']) }}" id="user-insurance">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.insurance.title_singular') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.personal_informations.create',['user_id'=>$user_id,'type'=>'edit'])}}" id="personal-info">Personal Medical Informations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.medical_informations.index',['user_id'=>$user_id])}}" id="medical-info">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.medical_informations.title_singular') }}</a>
                </li>
            </ul>
    </div>

    <div class="card-body">
    @can('medical_informations_create')
        <div style="margin-bottom: 10px;" class="row">
           <div class="col-md-3">
                <label for="">Member : <span class="text-danger">
                    @if(App\User::find($user_id)->gender == "male")
                        Mr.
                    @else
                        Ms.
                    @endif
                    {{App\User::find($user_id)->family_name}} {{App\User::find($user_id)->name}}</span></label>
           </div>
           <div class="col-md-3">
                <label for="">Date of Birth : <span class="text-danger">{{date('d-m-Y',strtotime(App\User::find($user_id)->dob))}}</span></label>
           </div>
           <div class="col-md-6 text-right">
               @if (isset(App\User::find($user_id)->userInsurance) && isset(App\User::find($user_id)->personalInformation))
                    <a class="btn btn-success" href="{{ route("admin.medical_infomations.create",['user_id'=>$user_id]) }}">
                        {{ trans('global.add') }} New Medical Info
                    </a>
               @else
                <div class="text-danger">
                    There is no {{App\User::find($user_id)->userInsurance ?'' : 'Member Insurance,'}} {{App\User::find($user_id)->personalInformation ?'' : 'Personal Infoamation'}}
                </div>
               @endif
            </div>
        </div>
    @endcan
        <div class="table-responsive">
            <!-- <table class=" table table-bordered table-striped table-hover datatable datatable-Hospitals" id="example"> -->
            <table class=" table table-bordered datatable datatable-Hospitals " id="example">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.medical_informations.fields.count') }}
                        </th>
                        <th>
                            Date of Visit
                        </th>
                        <th>
                            {{ trans('cruds.medical_informations.fields.history_code') }}
                        </th>
                        <!-- <th>
                            {{ trans('cruds.medical_informations.fields.medical_amount_total') }}
                        </th> -->                        
                        <th>
                            Hospital
                        </th>
                        <th>
                            Diagnosis
                        </th>
                         <th>
                            Status
                        </th>
                        <th>
                            PaymentType
                        </th>
                        <th>
                            Insurance
                        </th>
                        <th>
                            GCLNo.
                        </th>
                        <th style="width: 30px;">
                            180 daysPeriod
                        </th>                        
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medical_informations as $key => $medical_information)
                        <tr data-entry-id="{{ $medical_information->id }}">
                            <td>
                                <span class="badge badge-danger">
                                {{ $medical_information->medical_group($medical_information->disease_id,$medical_information->patient_id)->count() ?? 0}}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                {{--
                                {{ !empty($medical_information->the_first_visit_date) ? $medical_information->the_first_visit_date : '-' ?? ''}}
                                --}}
                                {{ !empty($medical_information->date_of_visit) ? $medical_information->date_of_visit : '-' ?? ''}}
                            </td>
                            <td>
                                {{$medical_information->ba_ref_no ?? '-'}}
                            </td>
                           <!--  <td>
                                {{ $medical_information->medical_group($medical_information->disease_id,$medical_information->patient_id)->sum('medical_amount') ?? 0}}
                            </td> -->
                            <td>
                                {{$medical_information->hospital->name ?? '-'}}
                            </td>                        
                            <td>
                                {{ $medical_information->medical->disease_name ?? ''}} 
                            </td>
                            <td>
                                @if($medical_information->medical_group($medical_information->disease_id,$medical_information->patient_id)->last()->treatment_status == 2)
                                    <span class="badge badge-success">End</span>
                                @else
                                    <span class="badge badge-danger">Ongoing</span>
                                @endif
                            </td>
                           <td>
                                {{App\UserInsurance::TYPE[$medical_information->payment_type]}}
                            </td>
                            <td>
                                {{ !empty($medical_information->insurance_id) ? $medical_information->insurance->company_name : '-' ?? ''}}
                            </td>
                            <td>
                                {{ !empty($medical_information->gcl_case_no) ? $medical_information->gcl_case_no : '-' ?? ''}}
                            </td>
                            <td>
                                {{ $medical_information->period_case ?? '-' }}
                            </td>
                            <td>
                                @can('medical_informations_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.medical_informations.detail_list', ['user_id'=>$user_id,'id'=>$medical_information->disease_id]) }}">
                                        History List
                                    </a>
                                @endcan
                                @can('medical_informations_create')
                                    @if($medical_information->medical_group($medical_information->disease_id,$medical_information->patient_id)->last()->treatment_status ==1 )
                                        <a class="btn btn-xs btn-warning" href="{{ route("admin.medical_infomations.create",['user_id'=>$medical_information->patient_id,'disease_id'=>$medical_information->disease_id]) }}">
                                            <i class="fas fa-plus"></i> Add
                                        </a>
                                    @endif
                                @endcan
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
<script>
    $(document).ready(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
         $.extend(true, $.fn.dataTable.defaults, {
            pageLength: 100,
          });
          $('.datatable-Hospitals:not(.ajaxTable)').DataTable({
               buttons: dtButtons ,
               "aaSorting": [] ,
               columnDefs: [{
                    className: '',
                    targets: 0
                }],
               scrollX:        true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 2,
                    rightColumns: 2
                }
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
</script>
@endsection

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
                    <a class="nav-link" href="{{route('admin.personal_informations.index',['user_id'=>$user_id])}}" id="medical-info">Personal Medical Informations</a>
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
                @if($medical_informations->last()->treatment_status ==1 )
                    <a class="btn  btn-warning" href="{{ route("admin.medical_infomations.create",['user_id'=>$user_id,'disease_id'=>$disease_id]) }}">
                        <i class="fas fa-plus"></i> Add
                    </a>
                @endif
            </div>
        </div>
    @endcan
        <div class="table-responsive">
            <table class=" table table-bordered datatable datatable-Hospitals " id="example">
                <thead>
                    <tr>
                        <th>
                            Date of Visit
                        </th>
                        <th>
                            {{ trans('cruds.medical_informations.fields.history_code') }}
                        </th>
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
                            Payment Type
                        </th>
                        <th>
                            Insurance
                        </th>
                        <th>
                            GCL Case No.
                        </th>
                        <th>
                            180 days Period
                        </th>                        
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medical_informations as $key => $medical_information)
                        <tr data-entry-id="{{ $medical_information->id }}">
                            <td>
                               {{--
                                {{ !empty($medical_information->the_first_visit_date) ? $medical_information->the_first_visit_date : '-' ?? ''}}
                                --}}
                                {{ !empty($medical_information->date_of_visit) ? $medical_information->date_of_visit : '-' ?? ''}}
                            </td>
                             <td>
                                {{$medical_information->ba_ref_no ?? '-'}}
                            </td>
                            <td>
                                {{$medical_information->hospital->name ?? '-'}}
                            </td>
                            <td>
                                {{$medical_information->medical->disease_name ?? '-'}}
                            </td>
                            <td>
                                {{ $medical_information->treatment_status == 1?'Ongoing' : 'Finish' }}
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
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.medical_informations.show', ['user_id'=>$user_id,'id'=>$medical_information->id]) }}"  data-toggle="tooltip" data-placement="top" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('medical_informations_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.medical_informations.edit',  ['user_id'=>$user_id,'id'=>$medical_information->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('medical_informations_delete')
                                    <form action="{{ route('admin.medical_informations.destroy', ['id'=>$medical_information->id,'user_id'=>$user_id]) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <a class="btn btn-md btn-default" href="{{route('admin.medical_informations.index',['user_id'=>$user_id])}}" id="medical-info">Back</a>
            </div>
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
                    leftColumns: 1,
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

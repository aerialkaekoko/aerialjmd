@extends('layouts.admin')
@section('content')
@section('title', 'Member Lists')
@can('members_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.register1") }}">
            {{ trans('global.add') }} {{ trans('cruds.members.title_singular') }}
        </a>

    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('admin.members.index')}}">{{ trans('cruds.members.title_singular') }} {{ trans('global.list') }}
                        <span class="badge badge-danger">{{$users->count()}}</span></a>
            </li>
            @can('report_access')
            <!--
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.invoice_reports')}}">InvoiceReports</a>
                </li>
            -->
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.patient_reports')}}" >PatientReports</a>
                </li>
            @endcan
        </ul>
    </div>

    <div class="card-body">
        <div class="row justify-content-end mb-2 country-filter">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-6">
                        <select class="form-control" id="country" style="font-size: 15px;">
                            <option value="">All Country</option>
                            @foreach(trans('cruds.countries') as $key=>$value)
                                <option value="{{$key}}" {{ (Request::get('country_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-6">
                        <select class="form-control" id="desk" style="font-size:15px">
                            <option value="">All Desk</option>
                            @foreach(trans('cruds.desk') as $key=>$value)
                                <option value="{{$key}}" {{ (Request::get('desk_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="table-responsive">            
            <table class=" table table-bordered table-striped table-hover datatable datatable-Member" id="table-member">
                <thead>
                        <th style="width: 10px;">
                            <!-- {{ trans('cruds.user.fields.ref_no') }} -->
                            Member No.
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            DOB
                        </th>
                        {{--
                        <th>
                            Hospital
                        </th>
                        <th>
                            Patient No.
                        </th>
                        --}}
                        <th>
                          {{ trans('cruds.members.fields.country') }}
                        </th>
                        {{--                      
                        <th>
                            Desk Name
                        </th>
                        --}}
                        <th style="padding-right: 2px;padding-left: 2px;">
                            Insurance Details
                        </th>
                        <th>
                            Medical History
                        </th>
                        
                        <th>
                            &nbsp;
                        </th>

                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr data-entry-id="{{ $user->id }}">
                        <td style="text-align: center;">
                            {{ $user->member_no ??'-'}}
                        </td>
                        <td>
                            @if($user->gender == "male")
                                Mr.
                            @else
                                Ms.
                            @endif
                            {{ $user->family_name ?? '' }} {{ $user->name ?? '' }}
                        </td>
                        <td>
                            {{ !empty($user->dob) ? date('Y-m-d',strtotime($user->dob)) : '-' ?? ''}}
                        </td>
                        {{--
                        <td>
                            @php
                                $personalInformation = $user->personalInformation;
                            @endphp
                            @isset($personalInformation->hospital)
                                {{$personalInformation->hospital->name}}
                            @endisset
                        </td>
                        <td>
                             @php
                                $personalInformation = $user->personalInformation;
                            @endphp
                                {{ !empty($personalInformation->hospital_patient_no) ? $personalInformation->hospital_patient_no : '-' ?? ''}}
                            
                        </td>
                        --}}
                        <td>
                            @foreach(trans('cruds.countries') as $key => $label)
                               @if($user->country ==$key)
                                {{$label}}
                               @endif
                            @endforeach
                        </td>
                        {{--
                        <td>
                            @foreach(trans('cruds.desk') as $key => $label)
                               @if($user->desk ==$key)
                                {{$label}}
                               @endif
                            @endforeach
                        </td>
                        --}}       
                        <td style="text-align: center;">
                            @php
                                $userInsurance = $user->userInsurance;
                            @endphp
                            @isset($userInsurance->insurance1)
                                <div>
                                    <a href="/admin/member/{{ $userInsurance->insurance1->template ?? '-' }}/{{$user->id}}" class=""
                                        target="_blank">{{$userInsurance->insurance1->company_name}}</a>
                                </div>
                            @endisset
                            @isset($userInsurance->insurance2)
                                <div>
                                    <a href="/admin/member/{{ $userInsurance->insurance2->template ?? '-' }}/{{$user->id}}" class=""
                                        target="_blank">{{$userInsurance->insurance2->company_name}}</a>
                                </div>
                            @endisset
                            @isset($userInsurance->insurance3)
                                <div>
                                    <a href="/admin/member/{{ $userInsurance->insurance3->template ?? '-' }}/{{$user->id}}" class=""
                                        target="_blank">{{$userInsurance->insurance3->company_name}}</a>
                                </div>
                            @endisset
                        </td>                  
                        <td>
                          <a href="{{route('admin.medical_informations.index',['user_id'=>$user->id])}}" class="btn btn-default">
                            Medical History 
                            <span class="badge badge-primary">{{ $user->medical_info->count()?? '' }}</span>
                          </a>
                        </td>
                                          
                        <td>
                            @can('members_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.members.edit', $user->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @can('members_delete')
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class='fas fa-trash'></i>
                                </button>
                            </form>
                            @endcan
                            @can('members_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.members.show', $user->id) }}"  data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
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
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    pageLength: 25,
  });
  var table = $('.datatable-Member:not(.ajaxTable)').DataTable({ buttons: dtButtons,"Sorting": [] });
  

})

    $('#country').on('change', function() {
        var desk=$('#desk').val();
        //alert(desk);
        var url = "{{route('admin.members.index')}}?desk_id="+ desk +"&country_id="+$(this).val();
        if (url) {
            window.location = url;
        }
        return false;
    });
    $('#desk').on('change', function() {
        var country=$('#country').val();
        var url = "{{route('admin.members.index')}}?country_id="+ country +"&desk_id="+$(this).val();
        if (url) {
            window.location = url;
        }
        return false;
    });
</script>
@endsection

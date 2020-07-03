@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">

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
                            <a class="nav-link active" href="{{route('admin.user-insurances.index',['user_id'=>$user_id])}}" id="user-insurance">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.insurance.title_singular') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.personal_informations.index',['user_id'=>$user_id])}}" id="personal_info">Personal Medical Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.medical_informations.index',['user_id'=>$user_id])}}" id="medical-info">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.medical_informations.title_singular') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    @can('user_insurance_create')
                        <div style="margin-bottom: 10px;" class="row">
                            <div class="col-md-6">
                                <label for="">Member : <span class="text-danger">{{App\User::find($user_id)->name}} {{App\User::find($user_id)->family_name}}</span></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-success" href="{{ route("admin.user-insurances.create",['user_id'=>$user_id,'type'=>'edit']) }}">
                                    {{ trans('global.add') }} {{ trans('cruds.userInsurance.title_singular') }}
                                </a>
                            </div>
                        </div>
                    @endcan
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-UserInsurance">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.policy_number') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.id_number') }}
                                    </th>          
                                    <th>
                                        {{ trans('cruds.userInsurance.fields.assistance') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userInsurance.fields.insurance') }}
                                    </th>
                                    <th>
                                      {{ trans('cruds.members.fields.expire') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userInsurances as $key => $userInsurance)
                                    <tr data-entry-id="{{ $userInsurance->id }}">
                                        <td>
                                            {{ $userInsurance->policy_number ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userInsurance->id_number ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userInsurance->assistance->assistance_name ?? '' }}
                                        </td>
                                        <td>
                                           
                                        </td>
                                        <td>
                                            
                                           @if(\Carbon\Carbon::parse($userInsurance->expire_date)->lt(\Carbon\Carbon::today()))
                                            <span style="color: #dc3545;font-weight: bold;">
                                                    {{  \Carbon\Carbon::parse($userInsurance->expire_date)->format('d/m/Y') }}
                                            </span>    
                                            @elseif (\Carbon\Carbon::parse($userInsurance->expire_date. ' - 10 days')->lte(\Carbon\Carbon::today()))
                                                <span style="color: #ffc107;font-weight: bold;">
                                                    {{  \Carbon\Carbon::parse($userInsurance->expire_date)->format('d/m/Y') }}
                                                </span>

                                            @else       
                                                <span>
                                                    {{ \Carbon\Carbon::parse($userInsurance->expire_date)->format('d/m/Y') }}
                                                </span>   
                                            @endif
                                        </td>
                                        <td>
                                            @can('user_insurance_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.user-insurances.show',['id'=>$userInsurance->id,'user_id'=>$user_id]) }}" data-toggle="tooltip" data-placement="top" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan

                                            @can('user_insurance_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.user-insurances.edit', ['id'=>$userInsurance->id,'user_id'=>$user_id]) }}"  data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('user_insurance_delete')
                                                <form action="{{ route('admin.user-insurances.destroy', ['id'=>$userInsurance->id,'user_id'=>$user_id]) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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


                </div>
            </div>

        </div>
    </div>
</div>
@endsection
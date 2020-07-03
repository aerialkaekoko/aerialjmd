@extends('layouts.admin')
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
                    <a class="nav-link" href="{{ route("admin.user-insurances.create",['user_id'=>$user_id,'type'=>'edit']) }}" id="user-insurance">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.insurance.title_singular') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.personal_informations.index',['user_id'=>$user_id])}}" id="personal-info">Personal Medical Informations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.medical_informations.index',['user_id'=>$user_id])}}" id="medical-info">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.medical_informations.title_singular') }}</a>
                </li>
            </ul>
    </div>

    <div class="card-body">
    @can('personal_informations_create')
        <div style="margin-bottom: 10px;" class="row">
           <div class="col-md-3">
                <label for="">Member : 
                    <span class="text-danger">
                    @if(App\User::find($user_id)->gender == "male")
                        Mr.
                    @else
                        Ms.
                    @endif
                    {{App\User::find($user_id)->family_name}} {{App\User::find($user_id)->name}}</span>
                </label>
           </div>
           <div class="col-md-3">
                <label for="">Date of Birth : <span class="text-danger">{{date('d-m-Y',strtotime(App\User::find($user_id)->dob))}}</span></label>
           </div>
           
        </div>
    @endcan
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Hospitals" id="example">
                
                <tbody>
                    @foreach($personal_informations as $key => $personal_information)
                        
                    @endforeach
                </tbody>
            </table>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th style="width: 30%;">
                            {{ trans('cruds.personal_informations.fields.id') }}
                        </th>
                        <td>
                            {{ $personal_information->id }}
                        </td>
                    </tr>
                     <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.hospital') }}
                        </th>
                        <td>
                             {{ !empty($personal_information->hospital->name) ? $personal_information->hospital->name : '-' ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.patient_no') }}
                        </th>
                        <td>
                             {{ !empty($personal_information->hospital_patient_no) ? $personal_information->hospital_patient_no : '-' ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.hospital2') }}
                        </th>
                        <td>
                             {{ !empty($personal_information->hospital2->name) ? $personal_information->hospital2->name : '-' ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.patient2_no') }}
                        </th>
                        <td>
                             {{ !empty($personal_information->hospital2_patient_no) ? $personal_information->hospital2_patient_no : '-' ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.hospital3') }}
                        </th>
                        <td>
                             {{ !empty($personal_information->hospital3->name) ? $personal_information->hospital3->name : '-' ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.patient3_no') }}
                        </th>
                        <td>
                            {{ !empty($personal_information->hospital3_patient_no) ? $personal_information->hospital3_patient_no : '-' ?? ''}}
                        </td>
                    </tr>
                     <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.disease') }}
                        </th>
                        <td>
                             {{ !empty($personal_information->medicals) ? $personal_information->medicals : '-' ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.history') }}
                        </th>
                        <td>
                            {{ $personal_information->medical_hystory ? $personal_information->medical_hystory : '-' ?? ""  }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.comments') }}
                        </th>
                        <td>
                            {{ $personal_information->comments ? $personal_information->comments : '-' ?? ""  }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.personal_informations.fields.materials') }}
                        </th>
                        <td>
                            @if($personal_information->materials)
                                @foreach($personal_information->materials as $key => $media)
                                 <a href="{{ $media->getUrl() }}" target="_blank">Materials Attachement</a>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col">
                    <a href="{{url()->previous()}}" class="btn btn-md btn-danger">Cancel</a>
                </div>
            <div class="col text-right">
                <a class="btn btn-md btn-info" href="{{ route('admin.personal_informations.edit',['id'=>$personal_information->id,'user_id'=>$user_id]) }}" id="personal-info">Edit</a>
            </div>            
        </div>
        
    </div>
</div>
@endsection
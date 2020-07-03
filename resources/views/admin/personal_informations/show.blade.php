@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} Personal Information
    </div>

    <div class="card-body">
        <div class="mb-2">
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
                             {{ !empty($personal_information->medical->disease_name) ? $personal_information->medical->disease_name : '-' ?? ''}}
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
        <div class="col-md-12">
            <a class="btn btn-md btn-default" href="{{route('admin.personal_informations.index',['user_id'=>$user_id])}}" id="personal-info">Back</a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')
@section('styles')
    <style>
        th{
            width: 50%;
        }
        td{
            width: 50%;
        }
    </style>
@endsection
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.medical_informations.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            
            <div class="wrapper center-block">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default border">
                    <div class="panel-heading active" role="tab" id="headingOne">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Treatment Info
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <table class="table table-bordered table-striped md">
                                <tr>
                                    <th>
                                        BA Ref No
                                    </th>
                                    <td>
                                        {{ $medical_information->ba_ref_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Member Id
                                    </th>
                                    <td>
                                        {{ $medical_information->user->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.medical_informations.fields.patient') }}
                                    </th>
                                    <td>
                                        @if($medical_information->user->gender == "male")
                                            Mr.
                                        @else
                                            Ms.
                                        @endif
                                        {{ $medical_information->user->family_name }} {{ $medical_information->user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Date Of Visit
                                    </th>
                                    <td>
                                        {{ !empty($medical_information->date_of_visit) ? date('Y-m-d',strtotime($medical_information->date_of_visit)) : '-' ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.medical_informations.fields.hospital') }}
                                    </th>
                                    <td>
                                        {{ !empty($medical_information->hospital->name) ? $medical_information->hospital->name : '-' ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Patient Number
                                    </th>
                                    <td>
                                        {{$medical_information->patient_no ?? '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Department
                                    </th>
                                    <td>
                                        {{$medical_information->department->department_name ?? '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Doctor
                                    </th>
                                    <td>
                                        {{$medical_information->doctor->name ?? '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        IPD/OPD
                                    </th>
                                    <td>
                                        {{ !empty($medical_information->opd_ipd ) ? $medical_information->opd_ipd == 1?'IPD' : 'OPD' : '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        IPD Start Date
                                    </th>
                                    <td>
                                        {{ !empty($medical_information->opd_ipd==1 ) ? $medical_information->ipd_start_date : '-' ?? '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        IPD Finish Date
                                    </th>
                                    <td>
                                        {{ !empty($medical_information->opd_ipd==1 ) ? $medical_information->ipd_finish_date : '-' ?? '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        First Visit
                                    </th>
                                    <td>
                                        {{date('Y-m-d',strtotime($medical_information->the_first_visit_date))  ??'-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Symptons
                                    </th>
                                    <td>
                                        {{$medical_information->symptons ??'-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Diagnosis
                                    </th>
                                    <td>
                                        {{ $medical_information->medical->disease_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Treatment Status
                                    </th>
                                    <td>
                                        {{ $medical_information->treatment_status == 1?'Ongoing' : 'Finish' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Appointment Date
                                    </th>
                                    <td>
                                        {{ !empty($medical_information->appointment_date) ? $medical_information->appointment_date : '-' ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Translator Name
                                    </th>
                                    <td>
                                        {{$medical_information->translator_name ?? '-'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Comments
                                    </th>
                                    <td>
                                        {{$medical_information->treatment_info_comments ?? '-'}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default border">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Receipt & GCL Info
                    </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <table class="table table-bordered table-striped md">
                            <tr>
                                <th>
                                    Payment Type
                                </th>
                                <td>
                                    {{App\UserInsurance::TYPE[$medical_information->payment_type]}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Insurance Company
                                </th>
                                <td>
                                    <a class=""
                                            href="/admin/member/{{ $medical_information->insurance->template ?? '-' }}/{{App\User::find($user_id)->id}}" target="_blank">
                                    {{ $medical_information->insurance->company_name ??'-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Assistance Company
                                </th>
                                <td>
                                    {{ $medical_information->assistance->assistance_name ??'-'}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status Of GCL
                                </th>
                                <td>
                                    {{ App\MedicalInformation::GCL_STATUS[$medical_information->status_of_gcl] }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    GCL Case No
                                </th>
                                <td>
                                    {{ $medical_information->gcl_case_no }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    180 days Period
                                </th>
                                <td>
                                    {{ $medical_information->period_case ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Medical Amount-1(USD)
                                </th>
                                <td>
                                    {{ $medical_information->medical_amount ?? 0}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Medical Amount-2(USD)
                                </th>
                                <td>
                                    {{ $medical_information->medical_amount2 ?? 0}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    KB
                                </th>
                                <td>
                                    {{ $medical_information->kb ?? 0}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Comments
                                </th>
                                <td>
                                    {{ $medical_information->gcl_info_comments?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                </div>
                <div class="panel panel-default border">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        GAD Use
                    </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <table class="table table-bordered table-striped md">
                            <tr>
                                <th>
                                    Weekday or Weekendday
                                </th>
                                <td>
                                    {{ !empty($medical_information->weekday_end) ? $medical_information->weekday_end == 1?'WD' : 'WE' : '-'}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Side Response
                                </th>
                                <td>
                                    {{ $medical_information->side_response == 1?"OnSide" : "Phone" ?? ''  }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Document to BA Office Date
                                </th>
                                <td>
                                    {{ $medical_information->document_date ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Comments
                                </th>
                                <td>
                                    {{ $medical_information->gad_use_comments ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                </div>
                <div class="panel panel-default border">
                <div class="panel-heading" role="tab" id="headingFour">
                    <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Attached Files
                    </a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                    <div class="panel-body">
                        <table class="table table-bordered table-striped md">
                            <tr>
                                <th>
                                    Medical Attachement
                                </th>
                    
                                <td>
                                    @if($medical_information->medicalinvoice)
                                        @foreach($medical_information->medicalinvoice as $key => $media)
                                         <a href="{{ $media->getUrl() }}" target="_blank">Medical Attached {{$key+1}} </a>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                </div>
                <div class="panel panel-default border">
                <div class="panel-heading" role="tab" id="headingFive">
                    <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Service Time
                    </a>
                    </h4>
                </div>
                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                              <tr>
                                <th width="40%">Date</th>
                                <th width="30%">In Time</th>
                                <th width="30%">Out Time</th>
                              </tr>
                            </thead>
                            <tbody>
                             @forelse ($medical_information->services as $service)
                                  <tr>
                                    <td width="40%">{{$service->service_date??'-'}}</td>
                                    <td width="30%">{{date('h:i A',strtotime($service->intime))}}</td>
                                    <td width="30%">{{date('h:i A',strtotime($service->outtime))}}</td>
                                  </tr>
                              @empty
                                  <tr><td colspan="3">No Service Time Yet !....</td></tr>
                              @endforelse
                            </tbody>
                          </table>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
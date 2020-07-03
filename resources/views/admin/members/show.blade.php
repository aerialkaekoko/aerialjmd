@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       <h2 class="text-capitalize">{{ $user->family_name }} {{ $user->name }}</h2>
    </div>

  <div class="card-body">

    <div class="container-fluid">

      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default border">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Personal Informations
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                   <table class="table table-bordered table-striped">
                     <tbody>
                        <tr>
                            <th style="width: 30%">
                                Member No.
                            </th>
                            <td>
                                {{ $user->member_no }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                                First Name
                            </th>
                            <td>
                                {{ !empty($user->family_name) ? $user->family_name : '-' ?? ''}}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                            Last Name
                            </th>
                            <td>
                                {{ !empty($user->name) ? $user->name : '-' ?? ''}}
                            </td>
                        </tr>
                        
                        <tr>
                            <th style="width: 30%">
                                {{ trans('cruds.user.fields.email') }}
                            </th>
                            <td>
                                <a href = "mailto:{{$user->email}}?subject = Invoice&body = Message">{{ !empty($user->email) ? $user->email : '-' ?? ''}}
                                </a>                             
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                                Date of Birth
                            </th>
                            <td>
                                {{ !empty($user->dob) ? date('Y-m-d',strtotime($user->dob)) : '-' ?? ''}}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                                {{ trans('cruds.members.fields.gender') }}
                            </th>
                            <td>
                                {{ App\User::GENDER_SELECT[$user->gender] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                            {{ trans('cruds.members.fields.address') }}
                            </th>
                            <td>
                                {{ !empty($user->address) ? $user->address : '-' ?? ''}}
                                
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                            {{ trans('cruds.members.fields.address_current') }}
                            </th>
                            <td>
                                {{ !empty($user->address_current) ? $user->address_current : '-' ?? ''}}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                            {{ trans('cruds.user.fields.phone') }}
                            </th>
                            <td>
                                {{ !empty($user->phone) ? $user->phone : '-' ?? ''}}                                
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                                Company Name
                            </th>
                            <td>
                                {{ !empty($user->company) ? $user->company : '-' ?? ''}} 
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                            {{ trans('cruds.user.fields.passport') }}
                            </th>
                            <td>
                                {{ !empty($user->passport) ? $user->passport : '-' ?? ''}}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                                {{ trans('cruds.user.fields.passport_pdf') }}
                            </th>
                            <td>
                               @if($user->passport_info)
                                @foreach($user->passport_info as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">Passport InFo pdf {{$key+1}}</a>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 30%">
                                Send Mail!
                            </th>
                            <td>
                                <a href="{{ url('https://outlook.live.com/mail/0/sentitems') }}" target="_blank">Mail To !</a>
                            </td>

                        </tr>
                        
                         {{--                     
                        <tr>
                            <th style="width: 30%">
                                {{ trans('cruds.user.fields.insurance_pdf') }}
                            </th>
                            <td>
                               @php
                                    $userInsurance = $user->userInsurance;
                                @endphp
                                @if($user_insurances->insurance)
                                    @foreach($user_insurances->insurance as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">Insurance InFo pdf {{$key+1}}</a>
                                    @endforeach
                                @endif                                
                            </td>
                        </tr>
                         
                        <tr>
                            <th style="width: 30%">
                                {{ trans('cruds.user.fields.gruntee _pdf') }}
                            </th>
                            <td>
                                @if($user->gruntee )
                                @foreach($user->gruntee  as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">Gruntee  PDF {{$key+1}}</a>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        --}}
                      </tbody>
                    </table>
                </div>
                </div>
              </div>
              
              <div class="panel panel-default border" style="margin:5px auto">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Personal Medical Informations
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                   <table class="table table-bordered table-striped">
                        <tbody>
                            @foreach($personal_informations as $key => $personal_information)
                            @if($personal_information->hospital)
                            <tr data-entry-id="{{ $personal_information->id }}">                                       
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.hospital') }}
                                </th>
                                <td>
                                    <a href="/admin/hospitals/{{$personal_information->hospital->id}}" target="_blank">{{ !empty($personal_information->hospital->name) ? $personal_information->hospital->name : '-' ?? ''}}</a>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.patient_no') }}
                                </th>
                                <td>
                                   {{ !empty($personal_information->hospital_patient_no) ? $personal_information->hospital_patient_no : '-' ?? ''}}
                                </td>
                            </tr>
                            @endif
                            @if($personal_information->hospital2)
                            <tr>
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.hospital2') }}
                                </th>
                                <td>
                                    <a href="/admin/hospitals/{{$personal_information->hospital2->id}}" target="_blank">{{ !empty($personal_information->hospital2->name) ? $personal_information->hospital2->name : '-' ?? ''}}</a>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.patient2_no') }}
                                </th>
                                <td>
                                    <a herf="/admin/hospitals/{{$personal_information->hospital2->id}}" target="_blank"> {{ !empty($personal_information->hospital2_patient_no) ? $personal_information->hospital2_patient_no : '-' ?? ''}}
                                </td>
                            </tr>
                            @endif
                            @if($personal_information->hospital3)
                            <tr>
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.hospital3') }}
                                </th>
                                <td>
                                    <a href="/admin/hospitals/{{ !empty($personal_information->hospital3->id) ? $personal_information->hospital3->id : '-' ?? ''}}" target="_blank">{{ !empty($personal_information->hospital3->name) ? $personal_information->hospital3->name : '-' ?? ''}}</a>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.patient3_no') }}
                                </th>
                                <td>
                                    {{ !empty($personal_information->hospital3_patient_no) ? $personal_information->hospital3_patient_no : '-' ?? ''}}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.disease') }}
                                </th>
                                <td>
                                    {{ !empty($personal_information->medical->disease_name) ? $personal_information->medical->disease_name : '-' ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.history') }}
                                </th>
                                <td>
                                    {{ $personal_information->medical_hystory ? $personal_information->medical_hystory : '-' ?? ""  }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30%">
                                    {{ trans('cruds.personal_informations.fields.comments') }}
                                </th>
                                <td>
                                    {{ $personal_information->comments ? $personal_information->comments : '-' ?? ""  }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30%">
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
                        @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="panel panel-default border">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Member Insurance
                      </a>
                    </h4>
                  </div>
                  @if (isset($user_insurances))
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                      <div class="table-responsive">
                              <table class=" table table-bordered table-striped table-hover datatable datatable-Insurance">
                                  <tbody>
                                      @if(in_array(1,unserialize($user_insurances->type)))
                                      @if($user_insurances->assistance1 || $user_insurances->insurance1 || $user_insurances->policy_number1 || $user_insurances->policy_period_from1 || $user_insurances->policy_period_to1)
                                          <tr>
                                              <th colspan="2"  class="text-center">OTAI 1</th>
                                          </tr>
                                          <tr>
                                              <th width="30%">Insurance Company</th>
                                              <td>
                                                  @isset($user_insurances->insurance1)
                                                      <a href="/admin/member/{{ $user_insurances->insurance1->template ?? '-' }}/{{$user->id}}" class="" target="_blank">{{$user_insurances->insurance1->company_name}}</a>
                                                  @endisset
                                              </td>
                                          </tr>
                                          <tr>
                                              <th width="30%">Assistance Company</th>
                                              <td><a href="/admin/assistances/{{$user_insurances->assistance1->id ?? '-'}}" class="" target="_blank">{{$user_insurances->assistance1->assistance_name ?? '-'}}</a></td>
                                          </tr>
                                          <tr>
                                              <th width="30%">Policy Number</th>
                                              <td>{{$user_insurances->policy_number1 ?? '-'}}</td>
                                          </tr>
                                          <tr>
                                              <th width="30%">Policy Period From</th>
                                              <td>{{$user_insurances->policy_period_from1 ?? '-'}}</td>
                                          </tr>
                                          <tr>
                                              <th width="30%">Policy Period To</th>
                                              <td>{{$user_insurances->policy_period_to1 ?? '-'}}</td>
                                          </tr>
                                      @endif
                                      @if($user_insurances->assistance2 || $user_insurances->insurance2 || $user_insurances->policy_number2 || $user_insurances->policy_period_from2 || $user_insurances->policy_period_to2)
                                          <tr>
                                              <th colspan="2"  class="text-center">OTAI 2</th>
                                          </tr>
                                          <tr>
                                              <th width="30%">Insurance Company</th>
                                              <td>
                                                  @isset($user_insurances->insurance2)
                                                      <a href="/admin/member/{{ $user_insurances->insurance2->template ?? '-' }}/{{$user->id}}" class=""
                                                      target="_blank">{{$user_insurances->insurance2->company_name}}</a>
                                                  @endisset
                                              </td>
                                          </tr>
                                          <tr>
                                              <th width="30%">Assistance Company</th>
                                              <td> 
                                                  @isset($user_insurances->assistance2)
                                                 <a href="/admin/assistances/{{$user_insurances->assistance2->id ?? '-'}}" target="_blank">
                                                    {{$user_insurances->assistance2->assistance_name ?? '-'}}
                                                   </a> 
                                                  @endisset  
                                              </td>
                                          </tr>
                                          <tr>
                                              <th width="30%">Policy Number</th>
                                              <td>{{$user_insurances->policy_number2 ?? '-'}}</td>
                                          </tr>
                                          <tr>
                                              <th width="30%">Policy Period From</th>
                                              <td>{{$user_insurances->policy_period_from2 ?? '-'}}</td>
                                          </tr>
                                          <tr>
                                              <th width="30%">Policy Period To</th>
                                              <td>{{$user_insurances->policy_period_to2 ?? '-'}}</td>
                                          </tr>
                                      @endif
                                      @endif
                                      @if(in_array(2,unserialize($user_insurances->type)))
                                      <tr>
                                          <th colspan="2"  class="text-center">Membership</th>
                                      </tr>
                                      <tr>
                                          <th width="30%">Membership Company</th>
                                          <td>{{$user_insurances->membership->company_name ?? '-'}}</td>
                                      </tr>
                                      <tr>
                                          <th width="30%">Membership No.</th>
                                          <td>{{$user_insurances->member_no ?? '-'}}</td>
                                      </tr>
                                      @endif
                                      @if(in_array(3,unserialize($user_insurances->type)))
                                      <tr>
                                          <th colspan="2"  class="text-center">Credit Card</th>
                                      </tr>
                                      <tr>
                                          <th width="30%">Credit Type</th>
                                          <td>{{$user_insurances->credit_type ?? '-'}}</td>
                                      </tr>
                                      <tr>
                                          <th width="30%">Insurance Company</th>
                                          <td>
                                              @isset($user_insurances->insurance3)
                                              <a href="/admin/member/{{ $user_insurances->insurance3->template ?? '-' }}/{{$user->id}}" class=""
                                                  target="_blank">{{$user_insurances->insurance3->company_name}}</a>
                                              @endisset
                                          </td>
                                      </tr>
                                      <tr>
                                          <th width="30%">Assistance Company</th>
                                          <td>{{$user_insurances->assistance3->assistance_name ?? '-'}}</td>
                                      </tr>
                                      @endif
                                      @if(in_array(4,unserialize($user_insurances->type)))
                                      <tr>
                                          <th colspan="2"  class="text-center">Others</th>
                                      </tr>
                                      <tr>
                                          <th width="30%">Others Type</th>
                                          <td>{{App\UserInsurance::OTHER_TYPE[$user_insurances->other_type]}}
                                          </td>
                                      </tr>
                                      @if($user_insurances->other_type==3) 
                                      <tr>
                                          <th width="30%">Local Insurance Company</th>
                                          <td>{{$user_insurances->local_insurance->company_name ?? '-'}}
                                          </td>
                                      </tr>
                                      @endif                      
                                      <tr>
                                          <th width="30%">Others Type Two</th>
                                          <td>{{App\UserInsurance::OTHER_TYPE[$user_insurances->other_type_two]}}
                                          </td>
                                      </tr>
                                      @if($user_insurances->other_type_two==3) 
                                      <tr>
                                          <th width="30%">Local Insurance Company</th>
                                          <td>{{$user_insurances->local_insurance->company_name ?? '-'}}
                                          </td>
                                      </tr>
                                      @endif                      
                                      @endif                                   
                                      <tr>
                                          <th style="width: 30%">
                                              {{ trans('cruds.user.fields.insurance_pdf') }}
                                          </th>
                                          <td>
                                             @if($user_insurances->insurance)
                                              @foreach($user_insurances->insurance as $key => $media)
                                              <a href="{{ $media->getUrl() }}" target="_blank">Insurance InFo pdf {{$key+1}}</a>
                                              @endforeach
                                              @endif
                                          </td>
                                      </tr>                                    
                                      <tr>
                                          <th style="width: 30%">
                                              Insurance PDF 2
                                          </th>
                                          <td>
                                             @if($user_insurances->template)
                                              @foreach($user_insurances->template as $key => $media)
                                              <a href="{{ $media->getUrl() }}" target="_blank">Insurance InFo2 pdf</a>
                                              @endforeach
                                              @endif
                                          </td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                              
                      </div>
                    </div>
                    @endif
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
@section('scripts')
    @parent
    <script>
        $(function () {
          $('.datatable-Hospitals:not(.ajaxTable)').DataTable({
            "bPaginate": false
          })
        })

    </script>
@endsection
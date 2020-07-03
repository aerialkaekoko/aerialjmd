@extends('layouts.admin')
@section('content')
	<div class="card">  
	    <div class="card-header">      
	         <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.members.index') }}">Member Lists</a>
              </li>
                <li class="nav-item">
                  <a class="nav-link " href="{{ route('admin.members.edit', $user->id) }}">Edit Member</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.user-insurances.index',['user_id'=>$user->id])}}" id="user-insurance">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.insurance.title_singular') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.medical_informations.index',['user_id'=>$user->id])}}" id="medical-info">{{ trans('cruds.members.title_singular') }} {{ trans('cruds.medical_informations.title_singular') }}</a>
                </li>
                <li class="nav-item">
                   <a href="{{route('admin.members.old_medical_info',['user_id'=>$user->id])}}" class="nav-link active">Old Medical Information</a>
                </li>
            </ul>     
	    </div>
        <div class="card-body">
             <label for="">Member : <span class="text-danger">{{App\User::find($user_id)->name}} {{App\User::find($user_id)->family_name}}</span></label>
            <form class="mt-2" method="POST" action="{{ route('admin.members.old_medical_info_update',$user_id) }}">
            @csrf
            <!-- @method('PUT') -->
            <div class="row">   
                <div class="col-md-4">
                    <!-- address -->
                    <div class="form-group {{ $errors->has('disease') ? 'has-error' : '' }}">
                        <label for="disease">{{ trans('cruds.members.fields.disease') }}</label>
                        <textarea id="disease" name="disease" class="form-control">{{ old('disease', isset($user) ? $user->disease : '') }}</textarea>
                        @if($errors->has('disease'))
                        <p class="help-block">
                            {{ $errors->first('disease') }}
                        </p>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.members.fields.disease_helper') }}
                        </p>
                    </div>
                    <!-- end address -->
                </div>
                <div class="col-md-4">
                    <!-- address_current -->
                    <div class="form-group {{ $errors->has('surgery') ? 'has-error' : '' }}">
                        <label for="surgery">{{ trans('cruds.members.fields.surgery') }}</label>
                        <textarea id="surgery" name="surgery"
                            class="form-control">{{ old('surgery', isset($user) ? $user->surgery : '') }}</textarea>
                            @if($errors->has('surgery'))
                            <p class="help-block">
                                {{ $errors->first('surgery') }}
                            </p>
                            @endif
                            <p class="helper-block">
                            {{ trans('cruds.members.fields.surgery_helper') }}
                           </p>
                    </div>                                                    
                    <!-- end address -->
                </div>
                <div class="col-md-4">
                    <!-- address_current -->
                    <div class="form-group {{ $errors->has('medicine') ? 'has-error' : '' }}">
                        <label for="medicine">{{ trans('cruds.members.fields.medicine') }}</label>
                        <textarea id="medicine" name="medicine"
                            class="form-control">{{ old('medicine', isset($user) ? $user->medicine : '') }}</textarea>
                            @if($errors->has('medicine'))
                            <p class="help-block">
                                {{ $errors->first('medicine') }}
                            </p>
                            @endif
                            <p class="helper-block">
                            {{ trans('cruds.members.fields.medicine_helper') }}
                           </p>
                    </div>                                                    
                    <!-- end address -->
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @if(Request::get('type') == 'create')
                        <a href="{{route('admin.members.index')}}" class="btn btn-md btn-success">Skip</a>
                    @else

                    @endif
                </div>
                <div class="col text-right">
                    <button type="submit" class="btn btn-md btn-info">Save </button>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection
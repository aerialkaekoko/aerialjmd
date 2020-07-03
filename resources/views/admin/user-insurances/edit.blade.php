@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.userInsurance.title_singular') }}
                </div>
                <div class="card-body">

                    <form action="{{ route("admin.user-insurances.update", ['id'=>$userInsurance->id,'user_id'=>$user_id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            <label for="user">{{ trans('cruds.userInsurance.fields.user') }}*</label>
                            <p class="text-danger">{{$userInsurance->user->name}} {{$userInsurance->user->family_name}}</p>
                            <input type="hidden" name="user_id" value="{{$user_id}}">
                            @if($errors->has('user_id'))
                                <p class="help-block">
                                    {{ $errors->first('user_id') }}
                                </p>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">                
                                <div class="form-group {{ $errors->has('policy_number') ? 'has-error' : '' }}">
                                    <label for="policy_number">{{ trans('cruds.user.fields.policy_number') }}*</label>
                                    <input type="text" id="policy_number" name="policy_number" class="form-control" value="{{ old('policy_number',$userInsurance->policy_number) }}" required>
                                    @if($errors->has('policy_number'))
                                        <p class="help-block">
                                            {{ $errors->first('policy_number') }}
                                        </p>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.policy_number_helper') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">                
                                <div class="form-group {{ $errors->has('id_number') ? 'has-error' : '' }}">
                                    <label for="id_number">{{ trans('cruds.user.fields.id_number') }}</label>
                                    <input type="text" id="id_number" name="id_number" class="form-control" value="{{ old('id_number',$userInsurance->id_number) }}" required>
                                    @if($errors->has('id_number'))
                                        <p class="help-block">
                                            {{ $errors->first('id_number') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Invoice Code">Expire Date *:</label>
                                    <input type="text" class="form-control" name="expire_date" id="expire_date" value=" {{date('Y-m-d',strtotime($userInsurance->expire_date))}}" placeholder="Enter Expire Date" autocomplete="off">
                                    <span class="error_expire_date text-danger"></span>
                                </div>
                            </div>                    
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('insurance_id') ? 'has-error' : '' }}">
                                <label for="insurance">{{ trans('cruds.userInsurance.fields.insurance') }}*</label>
                                <select name="insurance_id" id="insurance" class="form-control select2" required>
                                    @foreach($insurances as $id => $insurance)
                                        <option value="{{ $id }}" {{ (isset($userInsurance) && $userInsurance->insurance ? $userInsurance->insurance->id : old('insurance_id')) == $id ? 'selected' : '' }}>{{ $insurance }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('insurance_id'))
                                    <p class="help-block">
                                        {{ $errors->first('insurance_id') }}
                                    </p>
                                @endif
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('assistance_id') ? 'has-error' : '' }}">
                                    <label for="assistance">{{ trans('cruds.userInsurance.fields.assistance') }}*</label>
                                    <select name="assistance_id" id="assistance" class="form-control select2" >
                                        @foreach($assistances as $id => $assistance)
                                            <option value="{{ $id }}" {{ (isset($userInsurance) && $userInsurance->assistance ? $userInsurance->assistance->id : old('assistance_id')) == $id ? 'selected' : '' }}>{{ $assistance }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('assistance_id'))
                                        <p class="help-block">
                                            {{ $errors->first('assistance_id') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col">
                                <a href="{{url()->previous()}}" class="btn btn-md btn-danger">Cancel</a>
                            </div>
                            <div class="col text-right">
                                <input class="btn btn-info" type="submit" value="{{ trans('global.update') }}">
                            </div>
                        </div>
                    </form>


                </div>
            </div>

        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#insurance').on('change',function(){
                var insurance_id = $(this).val();
                $.ajax({
                    method : 'GET',
                    url : '/admin/get_insurances/'+insurance_id,
                    success : function(data){
                        if (data.success) {
                            $('#assistance option').remove();
                            $("#assistance").append('<option value="">Choose</option>');
                            $.each(data.data, function(){
                                    $("#assistance").append('<option value="'+ this.id +'">'+ this.assistance_name +'</option>');
                            });
                        }
                    }
                });
            })
            
            $('#expire_date').datepicker({
                dateFormat : 'yy-mm-dd',
                minDate : 0,
            });
        });
    </script>
@endsection
@endsection
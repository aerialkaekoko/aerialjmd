@extends('layouts.admin')
@section('styles')
    <style>
    /*form styles*/
#msform {
  width: 400px;
  margin: 10px auto;
  text-align: center;
  position: relative;
}

/*progressbar*/
#progressbar {
  overflow: hidden;
  /*CSS counters to number the steps*/
  counter-reset: step;
}

#progressbar li {
  list-style-type: none;
  text-transform: uppercase;
  font-size: 12px;
  width: 33.33%;
  float: left;
  position: relative;
}

#progressbar li:before {
  content: counter(step);
  counter-increment: step;
  width: 50px;
  line-height: 50px;
  display: block;
  font-size: 12px;
  color: #333;
  background: white;
  border: 1px solid #e3e3e3;
  border-radius: 50%;
  margin: 0 auto 5px auto;
}

/*progressbar connectors*/
#progressbar li:after {
  content: '';
  width: 60%;  /* Changed */
  height: 2px;
  background: #e3e3e3;
  position: absolute;
  left: -30%;  /* Changed */
  top: 25px;
  z-index: 1;  /* Changed */
}

#progressbar li:first-child:after {
  /*connector not needed before the first step*/
  content: none;
}

/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
  background: #27AE60;
  color: white;
}
    </style>
@endsection
@section('content')
	<div class="card">  
        <div class="row ">
            <div class="col progressbar">
                <form id="msform">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="">Member Register</li>
                        <li class="">User Insurance</li>
                        <li class="active">Personal Medical</li>
                    </ul>
                </form>
            </div>
        </div>
        <div class="card-body">
             <label for="">Member : <span class="text-danger">{{$user->family_name}} {{$user->name}}</span></label>
            <form class="mt-2" method="POST" action="{{ route('admin.register3') }}">
            @csrf
            <div class="hospital-list">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Hospital">Hospital 1 病院名 1:</label>
                            <select class="form-control select2" id="hospital" name="hospital_id" >
                                <option value="" data-country="">Please Select</option>
                                @foreach($hospitals as $id => $hospital)
                                    <option value="{{ $hospital->id }}" data-country="{{$hospital->country}}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Patient No">Hospital Patient No 患者番号:</label>
                        <input type="text" id="hospital_patient_no" name="hospital_patient_no" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Hospital">Hospital 2 病院名 2:</label>
                            <select class="form-control select2" id="hospital2" name="hospital2_id">
                                <option value="" data-country="">Please Select</option>
                                @foreach($hospitals as $id => $hospital)
                                    <option value="{{ $hospital->id }}" data-country="{{$hospital->country}}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Patient No">Hospital Patient No 患者番号:</label>
                        <input type="text" id="hospital2_patient_no" name="hospital2_patient_no" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Hospital">Hospital 3 病院名 3:</label>
                            <select class="form-control select2" id="hospital3" name="hospital3_id">
                                <option value="" data-country="">Please Select</option>
                                @foreach($hospitals as $id => $hospital)
                                    <option value="{{ $hospital->id }}" data-country="{{$hospital->country}}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Patient No">Hospital Patient No 患者番号:</label>
                        <input type="text" id="hospital3_patient_no" name="hospital3_patient_no" class="form-control">
                    </div>
                </div>
                <hr/>        
                <div class="row">
                    <div class="col-md-6">
                        <label for="Disease">Chronic Disease 慢性疾患:</label>
                        <input type="text" id="medicals" name="medicals" class="form-control" placeholder="Enter Chronic Disease"> 
                    </div>                
                </div> 
                <br/>
                <div class="row">
                    <div class="col-md-6">
                        <label for="Patient No">Past Medical Hystory 既往歴</label>
                        <textarea class="form-control" id="medical_hystory" name="medical_hystory" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="Sympton">Comments 自由記入欄</label>
                        <textarea class="form-control" id="comments" name="comments" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                        <button type="submit" class="btn  btn-default">Skip & Finish</button>
                </div>
                <div class="col text-right">
                    <a href="{{route('admin.register1')}}" class="btn btn-warning">Back To Member Register</a>
                    <a href="{{route('admin.register2')}}" class="btn btn-warning">Back To User Insurance</a>
                    <button type="submit" class="btn  btn-info">Save & Finish</button>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection
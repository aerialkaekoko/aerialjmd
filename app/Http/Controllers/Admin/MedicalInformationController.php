<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMedicalInformationRequest;
use App\Http\Requests\UpdateMedicalInformationRequest;
use App\MedicalInformation;
use App\User;
use App\Hospital;
use App\Medical;
use App\Insurance;
use App\Assistance;
use App\UserInsurance;
use App\Membership;
use App\Service;
use App\Department;
use App\Doctor;
use App\LocalInsurance;
use App\PersonalInformation;
use DB;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use App\Http\Controllers\Traits\MediaUploadingTrait;

class MedicalInformationController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id){
        abort_if(Gate::denies('medical_informations_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $d1 = new DateTime();
        $d1->modify('-6 month');
        $d1 = $d1->format('Y-m-d');
        $d2 = date('Y-m-d');
        $medical_informations = MedicalInformation::whereDate('created_at','>=',$d1)
                              ->whereDate('created_at','<=',$d2)
                              ->where('patient_id',$user_id)
                              ->groupBy('disease_id')
                              ->orderBy('created_at', 'desc')
                              ->get();
        return view('admin.medical_informations.index', compact('medical_informations','user_id'));
    }
    public function detail_list($user_id,$disease_id)
    {
        abort_if(Gate::denies('medical_informations_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $d1 = new DateTime();
        $d1->modify('-6 month');
        $d1 = $d1->format('Y-m-d');
        $d2 = date('Y-m-d');
        $medical_informations = MedicalInformation::whereDate('created_at','>=',$d1)->whereDate('created_at','<=',$d2)->where('patient_id',$user_id)->where('disease_id',$disease_id)->orderBy('ba_ref_no', 'asc')->get();
        return view('admin.medical_informations.detaillist', compact('medical_informations','user_id','disease_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$user_id)
    {
        abort_if(Gate::denies('medical_informations_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::find($user_id);
        $current_login_user = auth()->user();
        $medicals = Medical::all()->pluck('disease_name', 'id');
        $doctors = Doctor::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $departments = Department::all()->pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $localInsurances = LocalInsurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $memberships = Membership::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $hospitals = Hospital::all();
        $insurances = Insurance::all();
        $assistances = Assistance::all();
        if (isset($request->disease_id)) {
            $medical_information = MedicalInformation::where('disease_id',$request->disease_id)->where('patient_id',$user_id)->get()->last();
        }else{
            $medical_information = null;
        }
        return view('admin.medical_informations.create',compact('user','medicals','doctors','departments','medical_information','localInsurances','memberships','hospitals','insurances','assistances'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicalInformationRequest $request,$user_id)
    {
        
        //update user insurance
        $user = User::find($user_id);
        $userInsurance = $user->userInsurance;
        if (!in_array($request->payment_type,unserialize($userInsurance->type))) {
            $type = unserialize($userInsurance->type);
            array_push($type,$request->payment_type);
            $userInsurance->type = serialize($type);
            $userInsurance->membership_id = $request->membership_id;
            if ($request->payment_type == 3) {
                $userInsurance->credit_insurance_company = $request->insurance_id;
                $userInsurance->credit_assistance_company = $request->assistance_id;
            }
            if ($request->payment_type == 1) {
                $userInsurance->insurance_id1 = $request->insurance_id;
                $userInsurance->assistance_id1 = $request->assistance_id;
            }
            $userInsurance->corporate_company = $request->corporate_company;
            $userInsurance->local_insurance_id = $request->local_insurance_id;
            $userInsurance->cash_comments = $request->cash_comments;
            $userInsurance->other_comments = $request->other_comments;
            $userInsurance->save();
        }
        //end update user insurance
        $req_data = $request->except('_token');
        

        if ($request->payment_type == 1 || $request->payment_type == 3) {
            $assistance_short_code = Assistance::find($req_data['assistance_id'])->short_code;
        }elseif($request->payment_type == 2){
            $assistance_short_code = Membership::find($req_data['membership_id'])->membership_short_code;
        }else{
            $assistance_short_code = "NON";
        }
        $country_code =Hospital::find($request->hospital_id)->country_code;
       
        $today_count = MedicalInformation::whereDate('the_first_visit_date',$request->the_first_visit_date)
        ->where('branch_code',$country_code)
        ->groupBy('branch_code')
        ->count()+1;

        // if ($today_count == 1) {
        //     $order_no = 1;
        // }else{
        //     $order_no = MedicalInformation::where('branch_code',$country_code)
        //               ->count()+1;
        // }
        
        $jmd_ref_code = 'JMD'.$country_code.date('ymd',strtotime($request->the_first_visit_date)).'-'.$today_count.'-'.$assistance_short_code;

        // $today_count = MedicalInformation::whereDate('the_first_visit_date',$request->the_first_visit_date)->count()+1;
        // $jmd_ref_code = 'JMD'.$country_code.date('ymd',strtotime($request->the_first_visit_date)).'-'.$today_count.'-'.$assistance_short_code;


        
        $history_count = MedicalInformation::where('disease_id',$request->disease_id)->where('patient_id',$user_id)->get()->count();
        
        if ($history_count == 0) {
            $req_data['ba_ref_no'] = $jmd_ref_code;
            $req_data['branch_code'] = $country_code;
        }elseif($history_count == 1){
            $last_history_code = MedicalInformation::where('disease_id',$request->disease_id)->where('patient_id',$user_id)->get()->last()->ba_ref_no;
            $last_history_code = explode('-',$last_history_code);
            // dd($last_history_code);
            $jmd_ref_code = $last_history_code[0].'-'.$last_history_code[1].'-'.$last_history_code[2];
            if (count($last_history_code) == 4) {
                $last_history_code =$jmd_ref_code.'-'.($last_history_code[3]+1);
                $req_data['ba_ref_no'] = $last_history_code;
            } else {
                $req_data['ba_ref_no'] = $jmd_ref_code.'-1';
            }
        }else{
            $last_history_code = MedicalInformation::where('disease_id',$request->disease_id)->where('patient_id',$user_id)->get()->last()->ba_ref_no;
            $last_history_code = explode('-',$last_history_code);
            $jmd_ref_code = $last_history_code[0].'-'.$last_history_code[1].'-'.$last_history_code[2];
            $last_history_code =$jmd_ref_code.'-'.($last_history_code[3]+1);
            $req_data['ba_ref_no'] = $last_history_code;
        }
        $medical_information = MedicalInformation::create($req_data);
        //dd($req_data);

        $service = new Service;
        $service->medical_information_id = $medical_information->id;
        if ($request->opd_ipd == 1) {
            $service->service_date = $req_data['ipd_start_date'];
        } else {
            $service->service_date = $req_data['date_of_visit'];
        }
        $service->intime = $req_data['intime'];
        $service->outtime = $req_data['outtime'];
        $service->save();
        foreach ($request->input('medicalinfoform', []) as $file) {
            $medical_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('medicalinfoform');
        }
        foreach ($request->input('gruntee', []) as $file) {
            $medical_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('gruntee');
        }
        foreach ($request->input('medicalinvoice', []) as $file) {
            $medical_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('medicalinvoice');
        }
        foreach ($request->input('gcl', []) as $file) {
            $medical_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('gcl');
        }
            return redirect()->route('admin.medical_informations.detail_list',['user_id'=>$user_id,'id'=>$medical_information->disease_id]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id,$id)
    {
        abort_if(Gate::denies('medical_informations_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medical_information = MedicalInformation::find($id);
        return view('admin.medical_informations.show', compact('medical_information','user_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id,$id)
    {
        abort_if(Gate::denies('medical_informations_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medical_information = MedicalInformation::find($id);
        $medicals = Medical::all()->pluck('disease_name', 'id');
        $user = User::find($user_id);
        $doctors = Doctor::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $departments = Department::all()->pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $localInsurances = LocalInsurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $memberships = Membership::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $hospitals = Hospital::all();
        $insurances = Insurance::all();
        $assistances = Assistance::all();
        return view('admin.medical_informations.edit',compact('user','user_id','medicals','medical_information','doctors','departments','localInsurances','memberships','hospitals','insurances','assistances'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id,$id)
    {
         //update user insurance
        //  dd($request->all());
         $user = User::find($user_id);
         $userInsurance = $user->userInsurance;
         if (!in_array($request->payment_type,unserialize($userInsurance->type))) {
             $type = unserialize($userInsurance->type);
             array_push($type,$request->payment_type);
             $userInsurance->type = serialize($type);
             $userInsurance->membership_id = $request->membership_id;
             if ($request->payment_type == 3) {
                $userInsurance->credit_insurance_company = $request->insurance_id;
                $userInsurance->credit_assistance_company = $request->assistance_id;
            }
            if ($request->payment_type == 1) {
                $userInsurance->insurance_id1 = $request->insurance_id;
                $userInsurance->assistance_id1 = $request->assistance_id;
            }
             $userInsurance->corporate_company = $request->corporate_company;
             $userInsurance->local_insurance_id = $request->local_insurance_id;
             $userInsurance->cash_comments = $request->cash_comments;
             $userInsurance->other_comments = $request->other_comments;
             $userInsurance->save();
         }
         //end update user insurance
        $medical_information = MedicalInformation::find($id);
        $medical_information->update($request->all());
        if (count($medical_information->medicalinvoice) > 0) {
            foreach ($medical_information->medicalinvoice as $media) {
                if (!in_array($media->file_name, $request->input('medicalinvoice', []))) {
                    $media->delete();
                }
            }
        }

        $media = $medical_information->medicalinvoice->pluck('file_name')->toArray();
        foreach ($request->input('medicalinvoice', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $medical_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('medicalinvoice');
            }
        }
        if (count($medical_information->medicalinfoform) > 0) {
            foreach ($medical_information->medicalinfoform as $media) {
                if (!in_array($media->file_name, $request->input('medicalinfoform', []))) {
                    $media->delete();
                }
            }
        }

        $media = $medical_information->medicalinfoform->pluck('file_name')->toArray();
        foreach ($request->input('medicalinfoform', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $medical_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('medicalinfoform');
            }
        }

        if (count($medical_information->gruntee) > 0) {
            foreach ($medical_information->gruntee as $media) {
                if (!in_array($media->file_name, $request->input('gruntee', []))) {
                    $media->delete();
                }
            }
        }

        $media = $medical_information->gruntee->pluck('file_name')->toArray();

        foreach ($request->input('gruntee', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $medical_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('gruntee');
            }
        }
        if (count($medical_information->gcl) > 0) {
            foreach ($medical_information->gcl as $media) {
                if (!in_array($media->file_name, $request->input('gcl', []))) {
                    $media->delete();
                }
            }
        }

        $media = $medical_information->gcl->pluck('file_name')->toArray();

        foreach ($request->input('gcl', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $medical_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('gcl');
            }
        }

        return redirect()->route('admin.medical_informations.index',['user_id'=>$user_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id,$id)
    {
        abort_if(Gate::denies('medical_informations_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medical_information = MedicalInformation::find($id);
        $all_data = MedicalInformation::where('patient_id',$user_id)->where('disease_id',$medical_information->disease_id)->get();
        $all_ids = $all_data->pluck('id')->all();
        $filter_ids = array_filter($all_ids, function($n) use($id){ 
            return $n > $id;
        });
        if (count($filter_ids) > 0) {
            $update_ba_ref_no = $medical_information->ba_ref_no;
            foreach ($filter_ids as $key => $value) {
                $update_info = MedicalInformation::find($value);
                $update_info->ba_ref_no = $update_ba_ref_no;
                $update_ba_ref_no = MedicalInformation::find($value)->ba_ref_no;
                $update_info->save();
            }
        }
        $medical_information->delete();

        return back();
    }
    public function storeService(Request $request)
    {
        // dd($request->all());
        if(isset($request->service_time) && isset($request->service_outtime)){
            $service = new Service;
            $service->medical_information_id = $request->id;
            $service->service_date = $request->service_date;
            $service->intime = $request->service_time;
            $service->outtime = $request->service_outtime;
            $service->save();
        }
        return redirect()->route('admin.medical_informations.edit',['id'=>$request->id,'user_id'=>$request->user_id]);
    }
     public function updateService(Request $request,$id)
    {
        if(isset($request->service_time) && isset($request->service_outtime)){
            $service = Service::find($id);
            $service->medical_information_id = $request->id;
            $service->service_date = $request->service_date;
            $service->intime = $request->service_time;
            $service->outtime = $request->service_outtime;
            $service->save();
        }
        return redirect()->route('admin.medical_informations.edit',['id'=>$request->id,'user_id'=>$request->user_id]);
    }
    public function deleteService($user_id,$medical_info_id,$service_id)
    {
        $service = Service::find($service_id);
        $service->delete();

        return back();
    }
    public function get_assistances($insurance_id)
    {
         $assistances = Insurance::find($insurance_id)->assistances()->get();
         return response()->json(['success'=>true,'data'=>$assistances]);
    }
    public function get_last_patient_state($patient_id,$disease_id)
    {
        $last_patient_state = MedicalInformation::where('user_id',$patient_id)
                            ->where('medical_id',$disease_id)
                            ->where('finish',0)
                            ->get()->last();
        if ($last_patient_state) {
            return response()->json(['success'=>true,'data'=>$last_patient_state]);
        } else {
            return response()->json(['success'=>false]);
        }
        
    }
}
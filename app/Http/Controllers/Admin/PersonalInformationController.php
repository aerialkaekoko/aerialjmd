<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePersonalInformationRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\PersonalInformation;
use App\User;
use App\Hospital;
use App\Medical;
use App\Insurance;
use App\Assistance;
use App\Service;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use App\Http\Controllers\Traits\MediaUploadingTrait;

class PersonalInformationController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {        
        abort_if(Gate::denies('personal_informations_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $personalInformation = PersonalInformation::where('user_id',$user_id)->get();
        return view('admin.personal_informations.index', compact('personalInformation','user_id'));
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        abort_if(Gate::denies('personal_informations_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::find($user_id);
        $personalInformation = $user->personalInformation;
        $current_login_user = auth()->user();
        if ($current_login_user->name == 'admin') {
            // $hospitals = Hospital::all();
            $hospitals = Hospital::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $hospitals = Hospital::where('country',$current_login_user->country)->get();
        }
        $medicals = Medical::all()->pluck('disease_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.personal_informations.create',compact('user','hospitals','medicals','personalInformation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonalInformationRequest $request,$user_id)
    {
        if (isset($request->personal_id)>0) {
            $personalInformation = PersonalInformation::find($request->personal_id);
            $personalInformation->update($request->all());
            if (count($personalInformation->materials) > 0) {
                foreach ($personalInformation->materials as $media) {
                    if (!in_array($media->file_name, $request->input('materials', []))) {
                        $media->delete();
                    }
                }
            }    
            $media = $personalInformation->materials->pluck('file_name')->toArray();    
            foreach ($request->input('materials', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $personalInformation->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('materials');
                }
            }         
            
        }else{
            $personalInformation = PersonalInformation::create($request->all());
            
            foreach ($request->input('materials', []) as $file) {
                $personalInformation->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('materials');
            }
        }         
       
        if ($request->type == 'create') {
            return redirect()->route('admin.members.old_medical_info',['user_id'=>$user_id]);
        }else{
            return redirect()->back()->with(['success'=>'Successfully Save']);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id,$id)
    {
        abort_if(Gate::denies('personal_informations_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $personal_information = PersonalInformation::find($id);
        return view('admin.personal_informations.show', compact('personal_information','user_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id,$id)
    {
        abort_if(Gate::denies('personal_informations_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $personal_information = PersonalInformation::find($id);
        $current_login_user = auth()->user();
        if ($current_login_user->name == 'admin') {
            $hospitals = Hospital::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
             $hospitals = Hospital::where('country',$current_login_user->country)->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }
        $medicals = Medical::all()->pluck('disease_name', 'id')->prepend(trans('global.pleaseSelect'), '');      

        return view('admin.personal_informations.edit',compact('user_id','hospitals','medicals','personal_information'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonalInformationRequest $request, $user_id,$id){
        $personal_information = PersonalInformation::find($id);
        $personal_information->update($request->all());        

       $media = $personal_information->materials->pluck('file_name')->toArray();
        foreach ($request->input('materials', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $personal_information->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('materials');
            }
        }

        return redirect()->route('admin.personal_informations.index',['user_id'=>$user_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id,$id)
    {
        abort_if(Gate::denies('personal_informations_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $personal_information = PersonalInformation::find($id);
        $personal_information->delete();

        return back();
    }

    public function get_assistances($insurance_id)
    {
         $assistances = Insurance::find($insurance_id)->assistances()->get();
         return response()->json(['success'=>true,'data'=>$assistances]);
    }
    public function get_last_patient_state($patient_id,$disease_id)
    {
        $last_patient_state = PersonalInformation::where('user_id',$patient_id)
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
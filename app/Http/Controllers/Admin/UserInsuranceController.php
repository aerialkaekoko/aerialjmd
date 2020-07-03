<?php

namespace App\Http\Controllers\Admin;

use App\Assistance;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserInsuranceRequest;
use App\Http\Requests\StoreUserInsuranceRequest;
use App\Http\Requests\UpdateUserInsuranceRequest;
use App\Insurance;
use App\User;
use App\UserInsurance;
use App\Membership;
use App\LocalInsurance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserInsuranceController extends Controller{
    use MediaUploadingTrait;

    public function index($user_id){
        abort_if(Gate::denies('user_insurance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $userInsurances = UserInsurance::where('user_id',$user_id)->get();
        return view('admin.user-insurances.index', compact('userInsurances','user_id'));
    }

    public function create($user_id)
    {
        abort_if(Gate::denies('user_insurance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::find($user_id);
        $userInsurance = $user->userInsurance;
        $assistances = Assistance::all()->pluck('assistance_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $memberships = Membership::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $localInsurances = LocalInsurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $insurances = Insurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.user-insurances.create', compact('user','userInsurance','assistances','insurances','memberships','localInsurances'));
    }
    public function store(StoreUserInsuranceRequest $request,$user_id)
    {

        $serialize_type = serialize($request->type);
        $request['type'] = $serialize_type;
        if (isset($request->insurance_id)>0) {
            $userInsurance = UserInsurance::find($request->insurance_id);
            $userInsurance->update($request->all());
            if (count($userInsurance->insurance) > 0) {
                foreach ($userInsurance->insurance as $media) {
                    if (!in_array($media->file_name, $request->input('insurance', []))) {
                        $media->delete();
                    }
                }
            }    
            $media = $userInsurance->insurance->pluck('file_name')->toArray();    
            foreach ($request->input('insurance', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $userInsurance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('insurance');
                }
            }
            
            if (count($userInsurance->template) > 0) {
                foreach ($userInsurance->template as $media) {
                    if (!in_array($media->file_name, $request->input('template', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $userInsurance->template->pluck('file_name')->toArray();
            foreach ($request->input('template', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $userInsurance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('template');
                }
            }
        }else{
            $userInsurance = UserInsurance::create($request->all());
            foreach ($request->input('insurance', []) as $file) {
                $userInsurance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('insurance');
            }

            foreach ($request->input('template', []) as $file) {
                $userInsurance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('template');
            }
        }
        
        if ($request->type == 'create') {
            return redirect()->route('admin.members.old_medical_info',['user_id'=>$user_id]);
        }else{
            return redirect()->back()->with(['success'=>'Successfully Save']);
        }
    }

    public function edit($user_id,$id)
    {
        abort_if(Gate::denies('user_insurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $userInsurance = UserInsurance::find($id);
        
        $insurances = Insurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assistances  = Insurance::find($userInsurance->insurance_id)->assistances->pluck('assistance_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $userInsurance->load('user', 'assistance', 'insurance');

        return view('admin.user-insurances.edit', compact('user_id', 'assistances', 'insurances', 'userInsurance'));
    }

    public function update(UpdateUserInsuranceRequest $request, $user_id,$id)
    {
        $userInsurance = UserInsurance::find($id);
        $userInsurance->update($request->all());

        if ($request->input('template', false)) {
            if (!$userInsurance->template || $request->input('template') !== $userInsurance->template->file_name) {
                $userInsurance->addMedia(storage_path('tmp/uploads/' . $request->input('template')))->toMediaCollection('template');
            }
        }elseif ($userInsurance->template) {
            $userInsurance->template->delete();
        }

        return redirect()->route('admin.user-insurances.index',['user_id'=>$user_id]);
    }

    public function show($user_id,$id)
    {
        abort_if(Gate::denies('user_insurance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $userInsurance = UserInsurance::find($id);
        return view('admin.user-insurances.show', compact('userInsurance'));
    }

    public function destroy($user_id,$id)
    {
        abort_if(Gate::denies('user_insurance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $userInsurance = UserInsurance::find($id);
        $userInsurance->delete();
        return back();
    }

    public function massDestroy(MassDestroyUserInsuranceRequest $request)
    {
        UserInsurance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function get_insurance($insurance_id)
    {
        $insurance= Insurance::find($insurance_id);
        $assistances = $insurance->assistances;
        return response()->json(['success'=>true,'data'=>$assistances]);
    }
}

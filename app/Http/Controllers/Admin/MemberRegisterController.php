<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\StoreUserInsuranceRequest;
use App\User;
use App\Assistance;
use App\Insurance;
use App\UserInsurance;
use App\Membership;
use App\LocalInsurance;
use App\Hospital;
use App\Medical;
use App\PersonalInformation;

class MemberRegisterController extends Controller
{
    public function createRegister1(Request $request)
    {
    	$user = $request->session()->get('user');
        // dd($user);
    	$passport_info = $request->session()->get('passport_info');
        $insurance = $request->session()->get('insurance');
    	return view('admin.members.create',compact('user','passport_info','insurance'));
    }
    public function postCreateRegister1(StoreMemberRequest $request)
    {
        $validateUser = $request->except('_token');
        $memberCount = User::whereHas('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->count()+1;
        $member_no = "BA".str_pad($memberCount, 4, '0', STR_PAD_LEFT);
        $validateUser['member_no'] = $member_no;
    	if(empty($request->session()->get('user'))){
            $user = new User();
            $user->fill($validateUser);
            $request->session()->put('user', $user);
            $request->session()->put('passport_info', $request->passport_info);
            
        }else{
            $user = $request->session()->get('user');
            $user->fill($validateUser);
            $request->session()->put('user', $user);
            $request->session()->put('passport_info', $request->passport_info);
            
        }
        return redirect()->route('admin.register2');
    }
    public function createRegister2(Request $request)
    {
    	$user = $request->session()->get('user');
        $userInsurance = $request->session()->get('userInsurance');
        $insurance_document = $request->session()->get('insurance');
    	$assistances = Assistance::all()->pluck('assistance_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $memberships = Membership::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $localInsurances = LocalInsurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $insurances = Insurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
    	return view('admin.register.register2',compact('user','userInsurance','assistances','insurances','insurance_document','memberships','localInsurances'));
    }
    public function postCreateRegister2(StoreUserInsuranceRequest $request)
    {
        // dd($request->all());
        $serialize_type = serialize($request->type);
        $request['type'] = $serialize_type;
    	$validateUserInsurance = $request->except('_token');
    	if(empty($request->session()->get('userInsurance'))){
            $userInsurance = new UserInsurance();
            $userInsurance->fill($validateUserInsurance);
            $request->session()->put('userInsurance', $userInsurance);
            $request->session()->put('insurance', $request->insurance);
        }else{
            $userInsurance = $request->session()->get('userInsurance');
            $userInsurance->fill($validateUserInsurance);
            $request->session()->put('userInsurance', $userInsurance);
            $request->session()->put('insurance', $request->insurance);
        }
        return redirect()->route('admin.register3');
    }
     public function createRegister3(Request $request)
    {
    	$user = $request->session()->get('user');
        $current_login_user = auth()->user();
        if ($current_login_user->name == 'admin') {
            $hospitals = Hospital::all();
        }else{
            $hospitals = Hospital::where('country',$current_login_user->country)->get();
        }
        $medicals = Medical::all()->pluck('disease_name', 'id')->prepend(trans('global.pleaseSelect'), '');
    	return view('admin.register.register3',compact('user','hospitals','medicals'));
    }
     public function postCreateRegister3(Request $request)
    {
        // dd($request->all());
    	$validatePersonal = $request->except('_token');
        $personalInformation = new PersonalInformation();
        $personalInformation->fill($validatePersonal);
        $request->session()->put('personalInformation', $personalInformation);

       	$user = $request->session()->get('user');
       	$user->save();
       	$user->roles()->sync($request->input('roles', [3]));
        $passport_info = $request->session()->get('passport_info');
        if(isset($passport_info)){
            foreach ($request->session()->get('passport_info') as $file) {
                $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('passport_info');
            }
        }

        $fillUserInsurance = $request->session()->get('userInsurance');
        if(isset($fillUserInsurance)){
            $validateUserInsurance = ['user_id'=>$user->id];
       
            $fillUserInsurance->fill($validateUserInsurance);
            $request->session()->put('userInsurance', $fillUserInsurance);

            $userInsurance = $request->session()->get('userInsurance');
            $userInsurance->save();

            $insurance = $request->session()->get('insurance');
            if (isset($insurance)) {
                foreach ($request->session()->get('insurance') as $file) {
                    $userInsurance->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('insurance');
                }
            }
        }

        $fillPersonalInformation = $request->session()->get('personalInformation');
        $validateUserId = ['user_id'=>$user->id];
        $fillPersonalInformation->fill($validateUserId);
        $request->session()->put('personalInformation', $fillPersonalInformation);

        $personalInfoData = $request->session()->get('personalInformation');
        $personalInfoData->save();

       	$request->session()->forget(['user', 'userInsurance','passport_info','insurance','personalInformation']);
        return redirect()->route('admin.members.index');
    }
     public function storeMedia(Request $request)
    {
// Validates file size
        if (request()->has('size')) {
            $this->validate(request(), [
                'file' => 'max:' . request()->input('size') * 1024,
            ]);
        }

// If width or height is preset - we are validating it as an image
        if (request()->has('width') || request()->has('height')) {
            $this->validate(request(), [
                'file' => sprintf(
                    'image|dimensions:max_width=%s,max_height=%s',
                    request()->input('width', 100000),
                    request()->input('height', 100000)
                ),
            ]);
        }

        $path = storage_path('tmp/uploads');

        try {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        } catch (\Exception $e) {
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}

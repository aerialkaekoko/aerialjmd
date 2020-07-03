<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMembersRequest;
use App\Role;
use App\User;
use App\Insurance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MembersController extends Controller
{
    use MediaUploadingTrait;

    //  index
    public function index(Request $request)
    {
        abort_if(Gate::denies('members'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //dd($request->all());
            if (isset($request->country_id)) {
                if($request->desk_id==null){
                    $users = User::orderBy('created_at', 'desc')->whereHas('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->where('country',$request->country_id)->get();
                }else{
                $users = User::orderBy('created_at', 'desc')->whereHas('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->where('country',$request->country_id) ->where('desk', $request->desk_id)->get();
                }
            }elseif (isset($request->desk_id)){
                 if($request->country_id==null){
                     //dd("hello");
                    $users = User::orderBy('created_at', 'desc')->whereHas('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->where('desk',$request->desk_id)->get();
                }else{
                $users = User::orderBy('created_at', 'desc')->whereHas('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->where('country',$request->country_id) ->where('desk', $request->desk_id)->get();
                }
            }else{
                $users = User::orderBy('created_at', 'desc')->whereHas('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->get();
            }
        return view('admin.members.index', compact('users'));


    }

    //create
    public function create(User $user)
    {

     return view('admin.members.create');
    }

    //edit
   public function edit(Request $request,$id)
    {
        abort_if(Gate::denies('members_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

          $roles = Role::all()->pluck('title', 'id');
          $user = User::find($id);

        return view('admin.members.edit', compact('roles', 'user'));
    }

    //store
    public function store(StoreMemberRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', [3]));

        foreach ($request->input('passport_info', []) as $file) {
            $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('passport_info');
        }

        foreach ($request->input('insurance', []) as $file) {
            $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('insurance');
        }
        foreach ($request->input('gruntee', []) as $file) {
            $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('gruntee');
        }
        // return redirect()->back()->with('success','Member Successfully Save')->with('member',$user->id);
        return redirect()->route('admin.user-insurances.create',['user_id'=>$user->id,'type'=>'create']);
    }

    //update
    public function update(UpdateMembersRequest $request, $id)

    {
        $user = User::find($id);
        $user->update($request->all());
        // $user->roles()->sync($request->input('roles', [3]));

        if (count($user->passport_info) > 0) {
            foreach ($user->passport_info as $media) {
                if (!in_array($media->file_name, $request->input('passport_info', []))) {
                    $media->delete();
                }
            }
        }

        $media = $user->passport_info->pluck('file_name')->toArray();

        foreach ($request->input('passport_info', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('passport_info');
            }
        }

        if (count($user->insurance) > 0) {
            foreach ($user->insurance as $media) {
                if (!in_array($media->file_name, $request->input('insurance', []))) {
                    $media->delete();
                }
            }
        }

        $media = $user->insurance->pluck('file_name')->toArray();

        foreach ($request->input('insurance', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('insurance');
            }
        }

        if (count($user->gruntee) > 0) {
            foreach ($user->gruntee as $media) {
                if (!in_array($media->file_name, $request->input('gruntee', []))) {
                    $media->delete();
                }
            }
        }

        $media = $user->gruntee->pluck('file_name')->toArray();

        foreach ($request->input('gruntee', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('gruntee');
            }
        }

        return redirect()->route('admin.members.index');
    }
    



    //show
    public function show(Request $request,$id)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find($id);
        $user_insurances = $user->userInsurance;       
        $personal_informations = $user->personal_info()->get();
        // dd($user_insurances);   
       return view('admin.members.show', compact('user','user_insurances','personal_informations'));
    }

    //destroy
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

     public function old_medical_info($user_id)
    {
        $user = User::find($user_id);
        return view('admin.members.old_medical_info',compact('user_id','user'));
    }

    public function old_medical_info_update($user_id,Request $request)
    {
        $user = User::find($user_id);
        $user->disease = $request->disease;
        $user->surgery = $request->surgery;
        $user->medicine = $request->medicine;
        $user->save();
        return redirect()->back()->with(['message'=>'Save Successfully']);
    }


    public function claimtemplateone($id)
    {
        $user = User::find($id);
        $insurance=Insurance::find(1);
        $filename =public_path($insurance->template_pdf->getUrl());
        $address =$user->address;
        $currentaddress=$user->address_current;
        $name=$user->family_name.' '.$user->name;
        $dob=date_create($user->dob);
        $year=date_format($dob,"Y");
        $month=date_format($dob,"M");
        $day=date_format($dob,"d");
        $currentyear=date("Y");
        $currentmonth=date("M");
        $currentday=date("d");
        $age=$currentyear-$year;
        

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        // get the page count
        $pageCount = $pdf->setSourceFile($filename);
        // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust  the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            $pdf->SetFont('cid0jp', '', 8);

            $pdf->SetXY(45, 133);
            $pdf->Write(8, $name);

            $pdf->SetXY(150,121);
            $pdf->Write(8,  $currentyear);

            $pdf->SetXY(169,121);
            $pdf->Write(8,  $currentmonth);

            $pdf->SetXY(183,121);
            $pdf->Write(8,  $currentday);

            $pdf->SetXY(45,156);
            $pdf->Write(8,  $year);

            $pdf->SetXY(65,156);
            $pdf->Write(8,  $month);

            $pdf->SetXY(78,156);
            $pdf->Write(8,  $day);

            $pdf->SetXY(78,156);
            $pdf->Write(8,  $day);

            $pdf->SetXY(99,156);
            $pdf->Write(8,  $user->age);

            $pdf->SetXY(30,168);
            $pdf->Write(8,  $currentaddress);

            $pdf->SetXY(46,269);
            $pdf->Write(8,  $name);
        }

        // Output the new PDF
        $pdf->Output();  
    }
    public function claimtemplatetwo($id)
    {
        $user = User::find($id);
        $insurance=Insurance::find(2);
        $filename =public_path($insurance->template_pdf->getUrl());
        $address =$user->address;
        $currentaddress=$user->address_current;
        $name=$user->family_name.' '.$user->name;
        $dob=date_create($user->dob);
        $year=date_format($dob,"Y");
        $month=date_format($dob,"M");
        $day=date_format($dob,"d");
        $currentyear=date("Y");
        $currentmonth=date("M");
        $currentday=date("d");
        $age=$user->age;

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        // get the page count
        $pageCount = $pdf->setSourceFile($filename);
        // dd($pageCount);
        // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            if($pageNo==1){
                 $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            $pdf->SetFont('cid0jp', '', 8);

            $pdf->SetXY(65, 92);
            $pdf->Write(8, $age);

            $pdf->SetXY(148, 92);
            $pdf->Write(8, $year);

            $pdf->SetXY(165, 92);
            $pdf->Write(8, $month);

            $pdf->SetXY(177, 92);
            $pdf->Write(8, $day);

            $pdf->SetXY(75, 98);
            $pdf->Write(8, $currentaddress);

            $pdf->SetXY(75, 105);
            $pdf->Write(8, $address);

            $pdf->SetXY(75, 111);
            $pdf->Write(8, $user->phone);

            $pdf->SetXY(142, 111);
            $pdf->Write(8, $user->jpn_phone);

            $pdf->SetXY(60, 117);
            $pdf->Write(8, $user->email);

            }
            else{
                 $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            $pdf->SetFont('Helvetica');
            $pdf->SetXY(60, 32);
            $pdf->Write(8, $name);

            $pdf->SetFont('Helvetica');
            $pdf->SetXY(140, 32);
            $pdf->Write(8, date_format($dob,"Y-M-d"));
            }
           
        }

        // Output the new PDF
        $pdf->Output(); 
    }
    public function claimtemplatethree($id)

    {   
        $user = User::find($id);
        $insurance=Insurance::find(6);
        $filename =public_path($insurance->template_pdf->getUrl());
        $address =$user->address;
        $currentaddress=$user->address_current;
        $name=$user->family_name.' '.$user->name;
        $dob=date_create($user->dob);
        $year=date_format($dob,"Y");
        $month=date_format($dob,"M");
        $day=date_format($dob,"d");
        $currentyear=date("Y");
        $currentmonth=date("M");
        $currentday=date("d");
        $age=$currentyear-$year;

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        // get the page count
        $pageCount = $pdf->setSourceFile($filename);
       // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            if($pageNo==2){
            $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            $pdf->SetFont('cid0jp', '', 8);

            $pdf->SetXY(50, 106);
            $pdf->Write(8, $name);

            $pdf->SetFont('Helvetica');
            $pdf->SetXY(38, 66);
            $pdf->Write(8, $currentaddress);

           $pdf->SetFont('Helvetica');
            $pdf->SetXY(38, 75);
            $pdf->Write(8, $address);
            }else{
                $templateId = $pdf->importPage($pageNo);

                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            }
           
        }
        // Output the new PDF
       
        $pdf->Output();  
        
    }
    public function claimtemplatefour($id)
    {
        $user = User::find($id);
        $insurance=Insurance::find(5);
        $filename =public_path($insurance->template_pdf->getUrl());
        $address =$user->address;
        $currentaddress=$user->address_current;
        $name=$user->family_name.' '.$user->name;
        $dob=date_create($user->dob);
        $year=date_format($dob,"Y");
        $month=date_format($dob,"M");
        $day=date_format($dob,"d");
        $currentyear=date("Y");
        $currentmonth=date("M");
        $currentday=date("d");
        $age=$currentyear-$year;

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        // get the page count
        $pageCount = $pdf->setSourceFile($filename);
      
        // iterate through all pages
       for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            if($pageNo==1){
                 $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            $pdf->SetFont('cid0jp', '', 8);
            $pdf->SetXY(100, 55);
            $pdf->Write(8, $name);

            $pdf->SetXY(85, 89);
            $pdf->Write(8, $year);

            $pdf->SetXY(100, 89);
            $pdf->Write(8, $month);

            $pdf->SetXY(117, 89);
            $pdf->Write(8, $day);

            $pdf->SetXY(30, 105);
            $pdf->Write(8, $address);

            $pdf->SetXY(153, 105);
            $pdf->Write(8, $user->jpn_phone);

            $pdf->SetXY(25, 115);
            $pdf->Write(8, $currentaddress);

            $pdf->SetXY(153, 115);
            $pdf->Write(8, $user->phone);
            }
            else{
                 $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            
            }
           
        }
        // Output the new PDF
       
        $pdf->Output();  
    }
    public function claimtemplatefive($id)
    {
        $user = User::find($id);
        $insurance=Insurance::find(7);
        $filename =public_path($insurance->template_pdf->getUrl());
        $address =$user->address;
        $currentaddress=$user->address_current;
        $name=$user->family_name.' '.$user->name;
        $dob=date_create($user->dob);
        $year=date_format($dob,"Y");
        $month=date_format($dob,"M");
        $day=date_format($dob,"d");
        $currentyear=date("Y");
        $currentmonth=date("M");
        $currentday=date("d");
        $age=$currentyear-$year;

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        // get the page count
        $pageCount = $pdf->setSourceFile($filename);
        // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust  the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            $pdf->SetFont('cid0jp', '', 8);
            $pdf->SetXY(140, 109);
            $pdf->Write(8,  $name);

            $pdf->SetXY(160,145);
            $pdf->Write(8,  $year);

            $pdf->SetXY(175,145);
            $pdf->Write(8,  $month);

            $pdf->SetXY(186,145);
            $pdf->Write(8,  $day);

            $pdf->SetXY(35,155);
            $pdf->Write(8,  $currentaddress);

            $pdf->SetXY(160,155);
            $pdf->Write(8,  $user->phone);


            $pdf->SetXY(35,167);
            $pdf->Write(8,  $address);

            $pdf->SetXY(160,167);
            $pdf->Write(8,  $user->jpn_phone);

            $pdf->SetXY(35,173);
            $pdf->Write(8,  $user->email);

          
        }

        // Output the new PDF
        $pdf->Output();  
    }  
    public function claimtemplatesix($id)
    {
        $user = User::find($id);
        $insurance=Insurance::find(8);
        $filename =public_path($insurance->template_pdf->getUrl());
        $address =$user->address;
        $fname=$user->family_name;
        $currentaddress=$user->address_current;
        $name=utf8_decode($user->family_name.' '.$user->name);
        $dob=date_create($user->dob);
        $year=date_format($dob,"Y");
        $month=date_format($dob,"M");
        $day=date_format($dob,"d");
        $currentyear=date("Y");
        $currentmonth=date("M");
        $currentday=date("d");
        $age=$user->age;

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        // get the page count
        $pageCount = $pdf->setSourceFile($filename);
      
        // iterate through all pages
       for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            if($pageNo==1){
                $templateId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                $pdf->SetFont('cid0jp', '', 8);

                $pdf->SetXY(53, 114);
                $pdf->Write(8, $address);

                $pdf->SetXY(150, 133);
                $pdf->Write(8, $user->email);

                $pdf->SetXY(53, 145);
                $pdf->Write(8, $name);

                $pdf->SetXY(150, 140);
                $pdf->Write(8, $year);

                $pdf->SetXY(164, 140);
                $pdf->Write(8, $month);

                $pdf->SetXY(172, 140);
                $pdf->Write(8, $day);

                $pdf->SetXY(185, 140);
                $pdf->Write(8, $age);
            }
            if($pageNo==2){
                $templateId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            }
            if($pageNo==3){
                 $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            $pdf->SetXY(53, 26);
            $pdf->Write(8, $name);

            $pdf->SetXY(157, 26);
            $pdf->Write(8, $year);

            $pdf->SetXY(119, 26);
            $pdf->Write(8, $month);

            $pdf->SetXY(137, 26);
            $pdf->Write(8, $day);
          
            }
            if($pageNo==4){
                $templateId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                    $pdf->SetXY(125, 200);
                    $pdf->Write(8, $name);

                    $pdf->SetXY(152, 30);
                    $pdf->Write(8, date('Y/m/d'));
                
            }
           
        }
        // Output the new PDF
       
        return response($pdf->Output('S'))->withHeaders(['Content-Type' => 'application/pdf']);  
    }
    public function claimtemplateseven($id)
    {
        $user = User::find($id);
        $insurance=Insurance::find(3);
        $filename =public_path($insurance->template_pdf->getUrl());

        $address =$user->address;
        $currentaddress=$user->address_current;
        $name=$user->name;
        $fname=$user->family_name;
        $dob=date_create($user->dob);
        $year=date_format($dob,"Y");
        $month=date_format($dob,"M");
        $day=date_format($dob,"d");
        $currentyear=date("Y");
        $currentmonth=date("M");
        $currentday=date("d");
        $age=$currentyear-$year;

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        // get the page count
        $pageCount = $pdf->setSourceFile($filename);
      // iterate through all pages
       for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            if($pageNo==1){
                 $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                    $pdf->SetFont('cid0jp', '', 8);
                    $pdf->SetXY(160, 24);
                    $pdf->Write(8, $currentyear);

                    $pdf->SetXY(175, 24);
                    $pdf->Write(8, $currentmonth);

                    $pdf->SetXY(185, 24);
                    $pdf->Write(8, $currentday);

          
            }
            if($pageNo==2){
                 $templateId = $pdf->importPage($pageNo);
                  $pdf->AddPage();
                  // use the imported page and adjust the page size
               $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                    $pdf->SetFont('cid0jp', '', 8);
                    $pdf->SetXY(55, 146);
                    $pdf->Write(8, $user->family_name.' '.$name);

                    $pdf->SetFont('Helvetica');
                    $pdf->SetXY(149, 149);
                    $pdf->Write(8, $year);

                    $pdf->SetFont('Helvetica');
                    $pdf->SetXY(115, 148);
                    $pdf->Write(8, $month);

                    $pdf->SetFont('Helvetica');
                    $pdf->SetXY(132, 148);
                    $pdf->Write(8, $day);
                    

                    

           
            

            
            }
           
        }
        // Output the new PDF
       
        $pdf->Output();  
    }
    
    public function claimtemplateeight($id)
    {
        $user = User::find($id);
        $insurance=Insurance::find(4);
        $filename =public_path($insurance->template_pdf->getUrl());
        $address =$user->address;
        $currentaddress=$user->address_current;
        $name=$user->family_name.' '.$user->name;
        $dob=date_create($user->dob);
        $year=date_format($dob,"Y");
        $month=date_format($dob,"M");
        $day=date_format($dob,"d");
        $currentyear=date("Y");
        $currentmonth=date("M");
        $currentday=date("d");


        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        // get the page count
        $pageCount = $pdf->setSourceFile($filename);
      // iterate through all pages
       for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            if($pageNo==1){
                 $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            $pdf->SetFont('cid0jp', '', 8);
            
            
            $pdf->SetXY(50, 44);
            $pdf->Write(8, $name);

            $pdf->SetXY(156, 45);
            $pdf->Write(8, $year);

            $pdf->SetXY(175, 45);
            $pdf->Write(8, $month);

            $pdf->SetXY(190, 45);
            $pdf->Write(8, $day);

            $pdf->SetXY(40, 67);
            $pdf->Write(8, $currentaddress);

            $pdf->SetXY(40, 76);
            $pdf->Write(8, $address);


          
            }
            if($pageNo==2){
                 $templateId = $pdf->importPage($pageNo);
                  $pdf->AddPage();
                  // use the imported page and adjust the page size
                  $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            }

        
           
        }
        // Output the new PDF
       
        $pdf->Output();  
    }    
}

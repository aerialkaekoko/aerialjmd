<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Support\Facades\Auth;
use App\permission;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    use MediaUploadingTrait;

    //  index
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::whereHas('roles', function ($q) {$q->whereNotIn('roles.title', ['member']);})->get();

        
                
        // dd($users);
        // $users = User::all();
        //  $users = User::except('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->get();

        return view('admin.users.index', compact('users'));
    }



   //create
    public function create(User $user)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $permissions = Permission::all()->pluck('description', 'id');

        return view('admin.users.create', compact('roles'));
    }
    
    public function get_by_role($id)
        {
            $html = '';
            $role=Role::find($id);
            $permissions = $role->permissions;
            foreach ($permissions as $permission) {
            $html .= '<option value="'.$permission->id.'" selected>'.$permission->description.'</option>';
        }
            return response()->json(['html'=>$html]);
        }

   
    //edit
    public function edit(User $user)
    {
        
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
        
        $permissions = Permission::all()->pluck('description', 'id');

        $user->load('roles', 'permissions');

        return view('admin.users.edit', compact('roles', 'user','permissions'));
    }

     //store
    public function store(StoreuserRequest $request)
    {
        $user = User::create($request->all());
        $permissions=$request->input('permissions', []);
        $user->roles()->sync($request->input('roles', []));
       
       
        if($permissions == []){
            foreach ($request->roles as $key => $value) {
            $role = Role::find($value);
            $user->permissions()->sync($role->permissions()->get()->pluck('id')->toArray());
            }
        }else{
            $user->permissions()->sync($request->input('permissions', []));
        }

        foreach ($request->input('passport_info', []) as $file) {
            $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('passport_info');
        }

        foreach ($request->input('insurance', []) as $file) {
            $user->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('insurance');
        }


        return redirect()->route('admin.users.index');
    }


    //update
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->permissions()->sync($request->input('permissions', []));

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
        return redirect()->route('admin.users.index');
    }

   //show
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $user->load('roles',);

        return view('admin.users.show', compact('user'));
    }

    //destroy
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user->user_insurances()->delete();
        $user->personal_info()->delete();
        $user->medical_info()->delete();
        $user->delete();

        return back();
    }

    //user profile
    public function profile(){
       $user = Auth::user();

    	return view('profile', compact('user',$user));

    }

    public function update_avatar(Request $request){
               $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user = Auth::user();

            $avatarName = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

            $request->avatar->storeAs('avatars', $avatarName);

            $user->avatar = $avatarName;
            $user->save();

            return back()
                ->with('success', 'You have successfully upload image.');

    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

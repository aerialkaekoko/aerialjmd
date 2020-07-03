<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserAlertRequest;
use App\Http\Requests\StoreUserAlertRequest;
use App\Http\Requests\UpdateUserAlertRequest;
use App\User;
use App\UserAlert;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAlertsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_alert_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlerts = UserAlert::all();

        return view('admin.userAlerts.index', compact('userAlerts'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_alert_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id');

        return view('admin.userAlerts.create', compact('users'));
    }

    public function store(StoreUserAlertRequest $request)
    {
        $userAlert = UserAlert::create($request->all());
        $userAlert->users()->sync($request->input('users', []));

        foreach ($request->input('file', []) as $file) {
            $userAlert->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('file');
        }

        return redirect()->route('admin.user-alerts.index');
    }

    public function edit(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->load('users');

        return view('admin.userAlerts.edit', compact('userAlert'));
    }

    public function update(UpdateUserAlertRequest $request, UserAlert $userAlert)
    {
        $userAlert->update($request->all());
        $userAlert->users()->sync($request->input('users', []));

        if (count($userAlert->file) > 0) {
            foreach ($userAlert->file as $media) {
                if (!in_array($media->file_name, $request->input('file', []))) {
                    $media->delete();
                }
            }
        }

        $media = $userAlert->file->pluck('file_name')->toArray();

        foreach ($request->input('file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $userAlert->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('file');
            }
        }

        return redirect()->route('admin.user-alerts.index');
    }

    public function show(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->load('users');

        return view('admin.userAlerts.show', compact('userAlert'));
    }

    public function destroy(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserAlertRequest $request)
    {
        UserAlert::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function read(Request $request)
    {
        $alerts = \Auth::user()->userAlerts()->where('read', false)->get();

        foreach ($alerts as $alert) {
            $pivot       = $alert->pivot;
            $pivot->read = true;
            $pivot->save();
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHospitalRequest;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use App\Hospital;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HospitalController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('hospitals_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hospital = Hospital::all();

        return view('admin.hospitals.index', compact('hospital'));
    }

    public function create()
    {
        abort_if(Gate::denies('hospitals_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hospitals.create');
    }

    public function store(StoreHospitalRequest $request)
    {
        $hospital = Hospital::create($request->all());

        foreach ($request->input('hospitals_images', []) as $file) {
            $hospital->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('hospitals_images');
        }

        return redirect()->route('admin.hospitals.index');
    }

    public function edit(Hospital $hospital)
    {
      
        abort_if(Gate::denies('hospitals_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hospitals.edit', compact('hospital'));
    }

    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {

        $hospital->update($request->all());

        if (count($hospital->hospitals_images) > 0) {
            foreach ($hospital->hospitals_images as $media) {
                if (!in_array($media->file_name, $request->input('hospitals_images', []))) {
                    $media->delete();
                }
            }
        }

        $media = $hospital->hospitals_images->pluck('file_name')->toArray();

        foreach ($request->input('hospitals_images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $hospitals->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('hospitals_images');
            }
        }

        return redirect()->route('admin.hospitals.index');
    }

    public function show(Hospital $hospital)
    {
        abort_if(Gate::denies('hospitals_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hospitals.show', compact('hospital'));
    }

    public function destroy(Hospital $hospital)
    {
        abort_if(Gate::denies('hospitals_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hospital->delete();

        return back();
    }

    public function massDestroy(MassDestroyHospitalRequest $request)
    {
        Hospital::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

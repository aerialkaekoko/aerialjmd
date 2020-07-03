<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMedicalRequest;
use App\Http\Requests\StoreMedicalRequest;
use App\Http\Requests\UpdateMedicalRequest;
use App\Medical;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class MedicalController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('medicals_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medical = Medical::all();

        return view('admin.medicals.index', compact('medical'));
    }

    public function create()
    {
        abort_if(Gate::denies('medicals_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.medicals.create');
    }

    public function store(StoreMedicalRequest $request)
    {
        $medical = Medical::create($request->all());
        return redirect()->route('admin.medicals.index');
    }

    public function edit(Medical $medical)
    {
      
        abort_if(Gate::denies('medicals_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.medicals.edit',compact('medical'));
    }

    public function update(UpdateMedicalRequest $request, Medical $medical)
    {
        $medical->update($request->all());
        return redirect()->route('admin.medicals.index');
    }

    public function show(Medical $medical)
    {
        abort_if(Gate::denies('medicals_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.medicals.show', compact('medical'));
    }

    public function destroy(Medical $medical)
    {
        abort_if(Gate::denies('medicals_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $medical->delete();

        return back();
    }

    public function massDestroy(MassDestroyMedicalRequest $request)
    {
        Medical::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Assistance;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInsuranceRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use App\Insurance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InsuranceController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('insurance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $insurances = Insurance::all();

        return view('admin.insurances.index', compact('insurances'));
    }

    public function create()
    {
        abort_if(Gate::denies('insurance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.insurances.create');
    }

    public function store(StoreInsuranceRequest $request)
    {
         $insurance = Insurance::create($request->all());
        
        if ($request->input('template_pdf', false)) {
            $insurance->addMedia(storage_path('tmp/uploads/' . $request->input('template_pdf')))->toMediaCollection('template_pdf');
        }

        return redirect()->route('admin.insurances.index');
    }

    public function edit(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.insurances.edit', compact('insurance'));
    }

    public function update(UpdateInsuranceRequest $request, Insurance $insurance)
    {
        $insurance->update($request->all());
        if ($request->input('template_pdf', false)) {
            if (!$insurance->template_pdf || $request->input('template_pdf') !== $insurance->template_pdf->file_name) {
                $insurance->addMedia(storage_path('tmp/uploads/' . $request->input('template_pdf')))->toMediaCollection('template_pdf');
            }
        } elseif ($insurance->template_pdf) {
            $insurance->template_pdf->delete();
        }

        return redirect()->route('admin.insurances.index');
    }

    public function show(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.insurances.show', compact('insurance'));
    }

    public function destroy(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $insurance->delete();

        return back();
    }

    public function massDestroy(MassDestroyInsuranceRequest $request)
    {
        Insurance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
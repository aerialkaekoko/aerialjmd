<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLocalInsuranceRequest;
use App\Http\Requests\StoreLocalInsuranceRequest;
use App\Http\Requests\UpdateLocalInsuranceRequest;
use App\LocalInsurance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocalInsuranceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('local_insurance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $localInsurances = LocalInsurance::all();

        return view('admin.localInsurances.index', compact('localInsurances'));
    }

    public function create()
    {
        abort_if(Gate::denies('local_insurance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.localInsurances.create');
    }

    public function store(StoreLocalInsuranceRequest $request)
    {
        $localInsurance = LocalInsurance::create($request->all());

        return redirect()->route('admin.local-insurances.index');

    }

    public function edit(LocalInsurance $localInsurance)
    {
        abort_if(Gate::denies('local_insurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.localInsurances.edit', compact('localInsurance'));
    }

    public function update(UpdateLocalInsuranceRequest $request, LocalInsurance $localInsurance)
    {
        $localInsurance->update($request->all());

        return redirect()->route('admin.local-insurances.index');

    }

    public function show(LocalInsurance $localInsurance)
    {
        abort_if(Gate::denies('local_insurance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.localInsurances.show', compact('localInsurance'));
    }

    public function destroy(LocalInsurance $localInsurance)
    {
        abort_if(Gate::denies('local_insurance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $localInsurance->delete();

        return back();

    }

    public function massDestroy(MassDestroyLocalInsuranceRequest $request)
    {
        LocalInsurance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
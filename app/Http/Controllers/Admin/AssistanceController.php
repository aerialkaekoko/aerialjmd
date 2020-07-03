<?php

namespace App\Http\Controllers\Admin;

use App\Assistance;
use App\Insurance;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAssistanceRequest;
use App\Http\Requests\StoreAssistanceRequest;
use App\Http\Requests\UpdateAssistanceRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssistanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('assistance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assistances = Assistance::all();

        return view('admin.assistances.index', compact('assistances'));
    }

    public function create()
    {
        abort_if(Gate::denies('assistance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $insurances = Insurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.assistances.create',compact('insurances'));
    }

    public function store(StoreAssistanceRequest $request)
    {
        $assistance = Assistance::create($request->all());

        return redirect()->route('admin.assistances.index');
    }

    public function edit(Assistance $assistance)
    {
        abort_if(Gate::denies('assistance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $insurances = Insurance::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.assistances.edit', compact('assistance','insurances'));
    }

    public function update(UpdateAssistanceRequest $request, Assistance $assistance)
    {
        $assistance->update($request->all());

        return redirect()->route('admin.assistances.index');
    }

    public function show(Assistance $assistance)
    {
        abort_if(Gate::denies('assistance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.assistances.show', compact('assistance'));
    }

    public function destroy(Assistance $assistance)
    {
        abort_if(Gate::denies('assistance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assistance->delete();

        return back();
    }

    public function massDestroy(MassDestroyAssistanceRequest $request)
    {
        Assistance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
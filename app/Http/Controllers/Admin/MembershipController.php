<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMembershipRequest;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Membership;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MembershipController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('membership_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //dd($request->all());

        $memberships = Membership::all();

        return view('admin.memberships.index', compact('memberships'));
    }

    public function create()
    {
        abort_if(Gate::denies('membership_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.memberships.create');
    }

    public function store(StoreMembershipRequest $request)
    {
        $membership = Membership::create($request->all());

        return redirect()->route('admin.memberships.index');

    }

    public function edit(Membership $membership)
    {
        abort_if(Gate::denies('membership_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.memberships.edit', compact('membership'));
    }

    public function update(UpdateMembershipRequest $request, Membership $membership)
    {
        $membership->update($request->all());

        return redirect()->route('admin.memberships.index');

    }

    public function show(Membership $membership)
    {
        abort_if(Gate::denies('membership_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.memberships.show', compact('membership'));
    }

    public function destroy(Membership $membership)
    {
        abort_if(Gate::denies('membership_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $membership->delete();

        return back();

    }

    public function massDestroy(MassDestroyMembershipRequest $request)
    {
        Membership::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
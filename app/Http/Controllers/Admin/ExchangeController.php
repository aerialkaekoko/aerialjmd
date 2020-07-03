<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyExchangeRequest;
use App\Http\Requests\StoreExchangeRequest;
use App\Http\Requests\UpdateExchangeRequest;
use App\Exchange;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExchangeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('exchanges_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exchange = Exchange::orderBy('id','desc')->get();
        return view('admin.exchanges.index', compact('exchange'));
    }

    public function create()
    {
        abort_if(Gate::denies('exchanges_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.exchanges.create');
    }

    public function store(StoreExchangeRequest $request)
    {
        $exchange = Exchange::create($request->all());
        return redirect()->route('admin.exchanges.index');
    }

    public function edit(Exchange $exchange,Request $request)
    {
        abort_if(Gate::denies('exchanges_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $medical_exchange = $request->medical_exchange;
        $user_id = $request->user_id;
        return view('admin.exchanges.edit', compact('exchange','medical_exchange','user_id'));
    }

    public function update(UpdateExchangeRequest $request, Exchange $exchange)
    {
        $exchange->update($request->all());
        if(isset($request->medical_exchange)){
            return redirect('/admin/'.$request->user_id.'/medical_informations/create');
        }
        else{
            return redirect()->route('admin.exchanges.index');
        }
        
    }

    public function show(Exchange $exchange)
    {
        abort_if(Gate::denies('exchanges_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.exchanges.show', compact('exchange'));
    }

    public function destroy(Exchange $exchange)
    {
        abort_if(Gate::denies('exchange_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exchange->delete();

        return back();
    }

    public function massDestroy(MassDestroyExchangeRequest $request)
    {
        Exchange::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

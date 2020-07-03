<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceDescriptionRequest;
use App\Http\Requests\StoreInvoiceDescriptionRequest;
use App\Http\Requests\UpdateInvoiceDescriptionRequest;
use App\InvoiceDescription;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceDescriptionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('invoice_description_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice_description = InvoiceDescription::orderBy('id', 'desc')->get();
        

        return view('admin.invoice_descriptions.index', compact('invoice_description'));
    }

    public function create()
    {
        abort_if(Gate::denies('invoice_description_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.invoice_descriptions.create');
    }
    public function store(StoreInvoiceDescriptionRequest $request)
    {
        $invoice_description = InvoiceDescription::create($request->all());

        return redirect()->route('admin.invoice_descriptions.index');

    }

    public function edit(InvoiceDescription $invoice_description)
    {
        abort_if(Gate::denies('invoice_description_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.invoice_descriptions.edit', compact('invoice_description'));
    }

    public function update(UpdateInvoiceDescriptionRequest $request, InvoiceDescription $invoice_description)
    {
        $invoice_description->update($request->all());

        return redirect()->route('admin.invoice_descriptions.index');

    }

    public function show(InvoiceDescription $invoice_description)
    {
        abort_if(Gate::denies('invoice_description_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.invoice_descriptions.show', compact('invoice_description'));
    }

    public function destroy(InvoiceDescription $invoice_description)
    {
        abort_if(Gate::denies('invoice_description_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice_description->delete();

        return back();

    }

    public function massDestroy(MassDestroyInvoiceDescriptionRequest $request)
    {
        InvoiceDescription::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}

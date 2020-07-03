<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Expense;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expenses_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense = Expense::orderBy('id','desc')->get();
        return view('admin.expenses.index', compact('expense'));
    }

    public function create()
    {
        abort_if(Gate::denies('expenses_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.expenses.create');
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->all());
        return redirect()->route('admin.expenses.index');
    }

    public function edit(Expense $expense)
    {
        abort_if(Gate::denies('expenses_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.expenses.edit', compact('expense'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());

        return redirect()->route('admin.expenses.index');
    }

    public function show(Expense $expense)
    {
        abort_if(Gate::denies('expenses_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.expenses.show', compact('expense'));
    }

    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->delete();

        return back();
    }

    public function massDestroy(MassDestroyExpenseRequest $request)
    {
        Expense::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

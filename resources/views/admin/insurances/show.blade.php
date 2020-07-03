@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.insurance.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.id') }}
                        </th>
                        <td>
                            {{ $insurance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.company_name') }}
                        </th>
                        <td>
                            {{ $insurance->company_name }}
                        </td>
                    </tr>                    
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.phone') }}
                        </th>
                        <td>
                            {{ $insurance->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.address') }}
                        </th>
                        <td>
                            {{ $insurance->address }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.assistance.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.assistance.fields.id') }}
                        </th>
                        <td>
                            {{ $assistance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assistance.fields.assistance_name') }}
                        </th>
                        <td>
                            {{ $assistance->assistance_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Short Code
                        </th>
                        <td>
                            {{ $assistance->short_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Full Name
                        </th>
                        <td>
                            {{ $assistance->to_name ??'-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assistance.fields.email') }}
                        </th>
                        <td>
                            {{ $assistance->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assistance.fields.phone') }}
                        </th>
                        <td>
                            {{ $assistance->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assistance.fields.address') }}
                        </th>
                        <td>
                            {{ $assistance->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Insurance
                        </th>
                        <td>
                            {{ $assistance->insurance->company_name }}
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
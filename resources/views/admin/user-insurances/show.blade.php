@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.userInsurance.title') }}
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInsurance.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $userInsurance->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInsurance.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $userInsurance->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.policy_number') }}
                                    </th>
                                    <td>
                                        {{ $userInsurance->policy_number ? $userInsurance->policy_number : "-" ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.id_number') }}
                                    </th>
                                    <td>
                                        {{ $userInsurance->id_number ? $userInsurance->id_number : "-"  ?? '' }}
                                    </td>
                                </tr>                               
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInsurance.fields.assistance') }}
                                    </th>
                                    <td>
                                        {{ $userInsurance->assistance->assistance_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInsurance.fields.insurance') }}
                                    </th>
                                    <td>
                                        {{ $userInsurance->insurance->company_name ?? '' }}
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

        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.membership.title') }}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.membership.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $membership->id ?? ''}}
                                    </td>
                                </tr>                                
                                <tr>
                                    <th>
                                        {{ trans('cruds.membership.fields.company_name') }}
                                    </th>
                                    <td>
                                        {{ $membership->company_name ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Short Code
                                    </th>
                                    <td>
                                        {{ $membership->membership_short_code ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.memberships.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
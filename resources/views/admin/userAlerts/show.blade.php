@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userAlert.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userAlert.fields.id') }}
                        </th>
                        <td>
                            {{ $userAlert->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAlert.fields.alert_text') }}
                        </th>
                        <td>
                            {{ $userAlert->alert_text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Users
                        </th>
                        <td>
                            @foreach($userAlert->users as $id => $user)
                                <span class="label label-info label-many">{{ $user->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAlert.fields.file') }}
                        </th>
                        <td>
                            {{ $userAlert->file }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAlert.fields.created_at') }}
                        </th>
                        <td>
                            {{ $userAlert->created_at }}
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
@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.invoice_description.title') }}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.invoice_description.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $invoice_description->id ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.invoice_description.fields.description') }}
                                    </th>
                                    <td>
                                        {{ $invoice_description->description ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.invoice_descriptions.index') }}">
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
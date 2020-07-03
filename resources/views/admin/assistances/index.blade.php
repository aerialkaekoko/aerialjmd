@extends('layouts.admin')
@section('content')
@can('assistance_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.assistances.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.assistance.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.assistance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Assistance">
                <thead>
                    <tr>
                        
                        <th>
                            {{ trans('cruds.assistance.fields.assistance_name') }}
                        </th>
                        <th>
                            Short Code
                        </th>
                        <th>
                            {{ trans('cruds.assistance.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.assistance.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.assistance.fields.address') }}
                        </th>
                        <th>
                            Insurance
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assistances as $key => $assistance)
                        <tr data-entry-id="{{ $assistance->id }}">
                            
                            <td>
                                {{ $assistance->assistance_name ?? '' }}
                            </td>
                            <td>
                                {{ $assistance->short_code ?? '' }}
                            </td>
                            <td>
                                {{ $assistance->email ?? '' }}
                            </td>
                            <td>
                                {{ $assistance->phone ?? '' }}
                            </td>
                            <td>
                                {{ $assistance->address ?? '' }}
                            </td>
                            <td>
                                {{ $assistance->insurance->company_name ?? '' }}
                            </td>
                            <td>
                                @can('assistance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.assistances.show', $assistance->id) }}"data-toggle="tooltip" data-placement="top" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('assistance_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.assistances.edit', $assistance->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('assistance_delete')
                                    <form action="{{ route('admin.assistances.destroy', $assistance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                         <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Assistance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
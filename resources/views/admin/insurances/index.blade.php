@extends('layouts.admin')
@section('content')
@can('insurance_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.insurances.create") }}">
            {{ trans('global.add') }} {{ trans('cruds.insurance.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.insurance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Insurance">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.company_name') }}
                        </th>
                        
                        <th>
                            {{ trans('cruds.insurance.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.insurance.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.insurance.fields.template_pdf') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($insurances as $key => $insurance)
                        <tr data-entry-id="{{ $insurance->id }}">
                            <td>
                                {{ $insurance->company_name ?? '' }}
                            </td>                             
                            <td>
                                {{ $insurance->phone ?? '' }}
                            </td>
                            <td>
                                {{ $insurance->address ?? '' }}
                            </td>
                            <td>
                                @if($insurance->template_pdf)
                                <a href="{{ $insurance->template_pdf->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                                @endif
                            </td>
                            <td>
                                @can('insurance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.insurances.show', $insurance->id) }}" data-toggle="tooltip" data-placement="top" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('insurance_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.insurances.edit', $insurance->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('insurance_delete')
                                    <form action="{{ route('admin.insurances.destroy', $insurance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
  $('.datatable-Insurance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
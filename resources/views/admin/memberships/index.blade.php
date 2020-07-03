@extends('layouts.admin')
@section('content')
<div class="content">
    @can('membership_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.memberships.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.membership.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.membership.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Membership">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.membership.fields.company_name') }}
                                    </th>
                                    <th>
                                        Short Code
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($memberships as $key => $membership)
                                    <tr data-entry-id="{{ $membership->id }}">
                                        <td>
                                            {{ $membership->company_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $membership->membership_short_code ?? '' }}
                                        </td>
                                        <td>
                                            @can('membership_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.memberships.show', $membership->id) }}" data-toggle="tooltip" data-placement="top" title="Detail">
                                                     <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan

                                            @can('membership_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.memberships.edit', $membership->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('membership_delete')
                                                <form action="{{ route('admin.memberships.destroy', $membership->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('membership_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.memberships.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Membership:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
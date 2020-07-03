@extends('layouts.admin')
@section('content')
@can('exchanges_create')
   
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.exchanges.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.exchange.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Currency Exchange Lists        
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Hospitals">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.exchange.fields.created_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.exchange.fields.thb') }}
                        </th>
                        <th>
                            {{ trans('cruds.exchange.fields.lak') }}
                        </th>
                        <th>
                            {{ trans('cruds.exchange.fields.mmk') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exchange as $key => $exchange)
                        <tr data-entry-id="{{ $exchange->id }}">
                            <td>

                            </td>
                            <td>
                              {{ date('Y-m-d',strtotime($exchange->created_at))}}
                            </td>
                            <td>
                                {!! $exchange->exchange_thb ?? '' !!}
                            </td>
                            <td>
                                {!! $exchange->exchange_lak ?? '' !!}
                            </td>
                            <td>
                                {!! $exchange->exchange_mmk ?? '' !!}
                            </td>
                            <td>
                                {{--
                                @can('exchanges_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.exchanges.show', $exchange->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('exchanges_delete')
                                    <form action="{{ route('admin.exchanges.destroy', $exchange->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                                --}}
                                @can('exchanges_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.exchanges.edit', $exchange->id) }}"data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
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
@can('exchanges_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.exchanges.massDestroy') }}",
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
  $('.datatable-Exchanges:not(.ajaxTable)').DataTable({ buttons: dtButtons,
    columnDefs: [
     {
        targets: 0,
    }]
   })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
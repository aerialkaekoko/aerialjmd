@extends('layouts.admin')
@section('content')
@can('medicals_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.medicals.create") }}">
                {{ trans('global.add') }} Diagnosis
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Diagnosis Lists
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Hospitals">
                <thead>
                    <tr> 
                        <th style="width: 10px;">
                            No.
                        </th>                      
                        <th>
                            Diagnosis Name
                        </th>
                       
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medical as $key => $medical)
                        <tr data-entry-id="{{ $medical->id }}">
                            <td style="text-align: center;">
                                {{$key+1}}
                            </td>
                          
                             <td>
                               {{ $medical->disease_name ?? '' }}
                            </td>
                           
                            <td>
                                @can('medicals_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.medicals.show', $medical->id) }}" data-toggle="tooltip" data-placement="top" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('medicals_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.medicals.edit', $medical->id) }}"data-toggle="tooltip" data-placement="top" title="Edit">
                                         <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('medicals_delete')
                                    <form action="{{ route('admin.medicals.destroy', $medical->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
    order: [[ 0, 'asc' ]],
    pageLength: 100,
  });
  $('.datatable-Hospitals:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
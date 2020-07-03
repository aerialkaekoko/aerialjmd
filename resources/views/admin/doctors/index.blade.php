@extends('layouts.admin')
@section('styles')
    <style>
        th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            margin: 0 auto;
        }
        table.dataTable {
            margin-top:0 !important;
            margin-bottom:0 !important;
        }

    </style>
@endsection
@section('content')
@can('doctors_create')
     <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.doctors.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.doctors.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
           Doctor Lists       
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered datatable datatable-Hospitals">
                <thead>
                    <tr>
                        
                        {{--
                        <th>
                            {{ trans('cruds.doctors.fields.id') }}
                        </th>
                        --}}                       
                        <th>
                            {{ trans('cruds.doctors.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctors.fields.hospital_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctors.fields.specialist') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctors.fields.qualification') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctors.fields.schedule') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctors.fields.country') }}
                        </th>
                        {{--
                        <th>
                            {{ trans('cruds.doctors.fields.address') }}
                        </th>
                        --}}
                        <th>
                            {{ trans('cruds.doctors.fields.contact') }}
                        </th>
                        
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $key => $doctor)
                        <tr data-entry-id="{{ $doctor->id }}">
                            
                            {{--
                            <td>
                                {{ $doctor->id ?? '' }}
                            </td>
                            --}}
                            <td>
                                {{ $doctor->name ?? '' }}
                            </td>
                            <td>
                                {{ $doctor->hospital_name ?? '' }}
                                
                            </td>
                            <td>
                                {{ $doctor->specialist ?? '' }}
                            </td>
                            <td>
                                {{ $doctor->qualification ?? '' }}
                            </td>
                            <td>
                                {{ $doctor->schedule ?? '' }}
                            </td>
                            <td>
                                {{ $doctor->country ?? '' }}
                            </td>
                            {{--
                            <td>
                                {{ $doctor->address ?? '' }}
                            </td>
                            --}}
                            <td>
                                {{ $doctor->contact ?? '' }}
                            </td>
                            {{-- <td>
                                @if($doctor->doctors_images)
                                    @foreach($doctor->doctors_images as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                @endif
                            </td> --}}
                            <td>

                                @can('doctors_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.doctors.show', $doctor->id) }}" data-toggle="tooltip" data-placement="top" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('doctors_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.doctors.edit', $doctor->id) }}"data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                

                                @can('doctors_delete')
                                    <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
  $('.datatable-Hospitals:not(.ajaxTable)').DataTable({
       buttons: dtButtons ,
       scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 2
        }
    })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
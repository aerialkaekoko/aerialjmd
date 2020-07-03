@extends('layouts.admin')
@section('content')
@can('hospitals_create')
   
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.hospitals.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.hospitals.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Hospital Lists        
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Hospitals">
                <thead>
                    <tr>                        
                        {{--
                        <th>
                            {{ trans('cruds.hospitals.fields.id') }}
                        </th>
                        --}}
                        <th style="width: 15%">
                            {{ trans('cruds.hospitals.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.hospitals.fields.country') }}
                        </th> 
                        <th style="width: 15%">
                            {{ trans('cruds.hospitals.fields.country_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.hospitals.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.hospitals.fields.contact') }}
                        </th>
                        {{--
                        <th>
                            {{ trans('cruds.hospitals.fields.hospitals_images') }}
                        </th>
                        --}}
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hospital as $key => $hospital)
                        <tr data-entry-id="{{ $hospital->id }}">
                           
                            {{--
                            <td>
                                {{ $hospital->id ?? '' }}
                            </td>
                            --}}
                            <td>
                                {{ $hospital->name ?? '' }}
                            </td>
                            <td>
                                {{ trans( 'cruds.countries' )[$hospital->country]}}
                            </td>
                             <td style="text-align: center;">
                                {{ $hospital->country_code ?? '' }}
                            </td>
                            <td>
                                {{ $hospital->address ?? '' }}
                            </td>
                            <td>
                                {{ $hospital->contact ?? '' }}
                            </td>
                            {{--
                            <td>
                                @if($hospital->hospitals_images)
                                    @foreach($hospital->hospitals_images as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                        </a>
                                    @endforeach
                                @endif
                            </td>
                            --}}
                            <td>
                                @can('hospitals_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.hospitals.show', $hospital->id) }}"  data-toggle="tooltip" data-placement="top" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('hospitals_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.hospitals.edit', $hospital->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('hospitals_delete')
                                    <form action="{{ route('admin.hospitals.destroy', $hospital->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
  $('.datatable-Hospitals:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
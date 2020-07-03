@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       <h2 style="text-align: left;">Details for Doctors</h2>
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped doctors-table">
                <tbody>
                    <tr>
                        <th rowspan="9" style="width: 31%;background: #FFFFFF;">
                            <img src="{{ asset('images/doctor.jpg') }}" style="width: 300px;height: auto;">
                            {{--
                            @foreach($doctor->doctors_images as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl('') }}" width="300px" height="auto">
                                </a>
                            @endforeach
                            --}}
                        </th>
                        <th>
                             {{ $doctor->name }}
                        </th>
                    </tr>
                     <tr>
                        <th>
                          {{ $hospital_name }}
                        </th>
                    </tr>
                     <tr>
                        <th>
                            {{ trans('cruds.doctors.fields.specialist') }} : {{ $doctor->specialist }}
                        </th>
                    </tr>
                     <tr>
                        <th>
                            {{ trans('cruds.doctors.fields.qualification') }} : {{ $doctor->qualification }}
                        </th>
                    </tr>
                     <tr>
                        <th>
                            {{ trans('cruds.doctors.fields.schedule') }} : {{ $doctor->schedule }}
                        </th>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.doctors.fields.country') }} : {{ $doctor->country }}
                        </th>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.doctors.fields.address') }} : {{ $doctor->address }}
                        </th>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.doctors.fields.contact') }} : {!! $doctor->contact !!}
                        </th>
                    </tr>
                    {{-- 
                    <tr>
                        <th>
                            {{ trans('cruds.doctors.fields.doctors_images') }}
                        </th>
                        <td>
                            @foreach($doctor->doctors_images as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    --}}
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
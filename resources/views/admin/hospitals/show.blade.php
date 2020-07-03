@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h2 style="text-align: left;">Hospital Information</h2>
    </div>

    <div class="card-body">
        <div class="mb-2">

         <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>                      
                        {{ trans('cruds.hospitals.fields.name') }}                    
                    </th>
                    <td>
                        {{ $hospital->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>                      
                        {{ trans('cruds.hospitals.fields.country') }}
                    </th>
                    <td>
                        {{ trans( 'cruds.countries' )[$hospital->country]}}
                    </td>
                </tr>
                <tr>
                    <th>                      
                        {{ trans('cruds.hospitals.fields.country_code') }}                  
                    </th>
                    <td>
                        {{ $hospital->country_code ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>                      
                        {{ trans('cruds.hospitals.fields.contact') }}                   
                    </th>
                    <td>
                        {{ $hospital->contact ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>                      
                        {{ trans('cruds.hospitals.fields.description') }}                   
                    </th>
                    <td>
                         {!! $hospital->description ?? '' !!}
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
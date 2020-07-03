@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Show Diagnosis
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>                    
                    <tr>
                        <th>
                            Diagnosis Name
                        </th>
                        <td>
                            {{ $medical->disease_name }}
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
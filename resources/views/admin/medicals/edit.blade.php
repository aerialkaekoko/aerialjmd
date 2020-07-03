@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
       Edit Diagnosis
    </div>

    <div class="card-body">
        <form action="{{ route("admin.medicals.update", [$medical->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('disease_name') ? 'has-error' : '' }}">
                <label for="disease_name">Diagnosis Name *</label>
                <input type="text" id="disease_name" name="disease_name" class="form-control" value="{{ old('disease_name', isset($medical) ? $medical->disease_name : '') }}" required>
                @if($errors->has('disease_name'))
                    <p class="help-block">
                        {{ $errors->first('disease_name') }}
                    </p>
                @endif
                <p class="helper-block">
                    Diagnosis Name
                </p>
            </div>            

           
            <div class="text-right">
                <input class="btn btn-info" type="submit" value="{{ trans('global.update') }}">
            </div>
        </form>


    </div>
</div>
@endsection
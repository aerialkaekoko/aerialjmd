@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.assistance.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.assistances.update", [$assistance->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('assistance_name') ? 'has-error' : '' }}">
                  <label for="assistance_name">{{ trans('cruds.assistance.fields.assistance_name') }}*</label>
                  <input type="text" id="assistance_name" name="assistance_name" class="form-control" value="{{ old('assistance_name', isset($assistance) ? $assistance->assistance_name : '') }}" required>
                  @if($errors->has('assistance_name'))
                      <p class="help-block">
                          {{ $errors->first('assistance_name') }}
                      </p>
                  @endif
                  <p class="helper-block">
                      {{ trans('cruds.assistance.fields.assistance_name_helper') }}
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('short_code') ? 'has-error' : '' }}">
                    <label for="short_code">Short Code*</label>
                    <input type="text" id="short_code" name="short_code" class="form-control" value="{{ old('short_code', isset($assistance) ? $assistance->short_code : '') }}" required>
                    @if($errors->has('short_code'))
                        <p class="help-block">
                            {{ $errors->first('short_code') }}
                        </p>
                    @endif
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-6">                    
                    <div class="form-group {{ $errors->has('to_name') ? 'has-error' : '' }}">
                        <label for="to_name">Full Name :</label>
                        <input type="text" id="to_name" name="to_name" class="form-control" value="{{ old('to_name', isset($assistance) ? $assistance->to_name : '') }}" >
                        @if($errors->has('to_name'))
                            <p class="help-block">
                                {{ $errors->first('to_name') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('cruds.assistance.fields.email') }}</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($assistance) ? $assistance->email : '') }}">
                @if($errors->has('email'))
                    <p class="help-block">
                        {{ $errors->first('email') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.assistance.fields.email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label for="phone">{{ trans('cruds.assistance.fields.phone') }}</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($assistance) ? $assistance->phone : '') }}">
                @if($errors->has('phone'))
                    <p class="help-block">
                        {{ $errors->first('phone') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.assistance.fields.phone_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('cruds.assistance.fields.address') }}</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($assistance) ? $assistance->address : '') }}">
                @if($errors->has('address'))
                    <p class="help-block">
                        {{ $errors->first('address') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.assistance.fields.address_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('insurance_id') ? 'has-error' : '' }}">
                <label for="insurance">{{ trans('cruds.userInsurance.fields.insurance') }}*</label>
                <select name="insurance_id" id="insurance" class="form-control select2" required="">
                    @foreach($insurances as $id => $insurance)
                        <option value="{{ $id }}"  {{ (isset($assistance) && $assistance->insurance ? $assistance->insurance->id : old('insurance_id')) == $id ? 'selected' : '' }}>{{ $insurance }}</option>
                    @endforeach
                </select>
                @if($errors->has('insurance_id'))
                    <p class="help-block">
                        {{ $errors->first('insurance_id') }}
                    </p>
                @endif
            </div>
            <div class="text-right">
                <input class="btn btn-info" type="submit" value="{{ trans('global.update') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
    var uploadedNewsImagesMap = {}
Dropzone.options.newsImagesDropzone = {
    url: '{{ route('admin.news.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="news_images[]" value="' + response.name + '">')
      uploadedNewsImagesMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedNewsImagesMap[file.name]
      }
      $('form').find('input[name="news_images[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($news) && $news->news_images)
      var files =
        {!! json_encode($news->news_images) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="news_images[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@stop
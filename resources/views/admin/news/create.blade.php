@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.news.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.news.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ trans('cruds.news.fields.title') }}</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($news) ? $news->title : '') }}">
                @if($errors->has('title'))
                    <p class="help-block">
                        {{ $errors->first('title') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.news.fields.title_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('cruds.news.fields.description') }}</label>
                <textarea id="description" name="description" class="form-control ckeditor">{{ old('description', isset($news) ? $news->description : '') }}</textarea>
                @if($errors->has('description'))
                    <p class="help-block">
                        {{ $errors->first('description') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.news.fields.description_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('news_images') ? 'has-error' : '' }}">
                <label for="news_images">{{ trans('cruds.news.fields.news_images') }}</label>
                <div class="needsclick dropzone" id="news_images-dropzone">

                </div>
                @if($errors->has('news_images'))
                    <p class="help-block">
                        {{ $errors->first('news_images') }}
                    </p>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.news.fields.news_images_helper') }}
                </p>
            </div>
            <div class="text-right">
                <input class="btn btn-info" type="submit" value="{{ trans('global.save') }}">
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
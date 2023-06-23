@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Posts Edit')

@section('content')

<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" value="{{old('title', $post->title)}}">
            @if($errors->has('title'))
            <div class="text-danger">{{ $errors->first('title') }}</div>
            @endif
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Content</label>
            <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content', $post->content) !!}</textarea>
            @if($errors->has('content'))
            <div class="text-danger">{{ $errors->first('content') }}</div>
            @endif
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Thumbnail</label>
            @if($post->thumbnail)
            <img src="{{ $post->thumbnail->getUrl() }}" alt="" width="150px" height="150px">
            @endif
            <input type="file" class="form-control" name="thumbnail">
            @if($errors->has('thumbnail'))
            <div class="text-danger">{{ $errors->first('thumbnail') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function SimpleUploadAdapter(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                return {
                    upload: function() {
                        return loader.file.then(function(file) {
                            return new Promise(function(resolve, reject) {
                                // Init request
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', "{{ route('admin.posts.media.upload', ['_token' => csrf_token() ]) }}", true);
                                xhr.setRequestHeader('Accept', 'application/json');
                                xhr.responseType = 'json';
                                // Init listeners
                                var genericErrorText = `Couldn't upload file: ${ file.name }.`;

                                xhr.addEventListener('error', function() {
                                    reject(genericErrorText)
                                });
                                xhr.addEventListener('abort', function() {
                                    reject()
                                });
                                xhr.addEventListener('load', function() {
                                    var response = xhr.response;
                                    if (!response || xhr.status !== 201) {

                                        return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);

                                    }
                                    $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');
                                    resolve({
                                        default: response.url
                                    });
                                });

                                if (xhr.upload) {
                                    xhr.upload.addEventListener('progress', function(e) {
                                        if (e.lengthComputable) {
                                            loader.uploadTotal = e.total;
                                            loader.uploaded = e.loaded;
                                        }
                                    });
                                }
                                // Send request
                                var data = new FormData();
                                data.append('upload', file);
                                data.append('crud_id', '{{ $news->id ?? 0 }}');
                                xhr.send(data);
                            });
                        })
                    }
                };
            }
        }

        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(
                allEditors[i], {
                    extraPlugins: [SimpleUploadAdapter]
                }
            );
        }
    });
</script>
@endpush
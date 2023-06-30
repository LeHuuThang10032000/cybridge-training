@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Posts Detail')

@section('content')

<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <div class="d-flex align-items-center flex-column">
        <div class="mb-3">
            @if($post->thumbnail !== null)
            <img src="{{ $post->thumbnail->getUrl() }}" alt="" width="100%">
            @endif
        </div>

        <div class="mb-5">
            <p class="h5">{{ $post->title }}</p>
        </div>
    </div>

    <div class="mb-3">
        Url: <a href="{{ $post->url }}">{{ $post->url }}</a>
    </div>
    <div class="mb-3 p-1 bg-light">
        {!! $post->content !!}
    </div>
    <div class="mb-3">
        <address class="author">By {{ $post->author->name }}</address>
        on <time pubdate datetime="{{ $post->created_at }}" title="{{ $post->created_at }}">"{{ $post->created_at }}"</time>
    </div>
</div>

<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <p class="">Write a comment:</p>
    <form class="mb-0" action="{{ route('admin.comments.store') }}" method="POST">
        @csrf
        <input type="hidden" value="{{ $post->id }}" name="post_id">
        <x-forms.ckeditor content="{{old('content', '')}}" />
        @if($errors->has('content'))
        <div class="text-danger">{{ $errors->first('content') }}</div>
        @endif
        <button type="submit" class="btn btn-primary mt-1">Submit</button>
    </form>
</div>

<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <p>Comments:</p>
    @include('admin.posts.comments', ['comments' => $post->comments, 'post_id' => $post->id])
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
                                xhr.open('POST', "{{ route('admin.comments.media.upload', ['_token' => csrf_token() ]) }}", true);
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
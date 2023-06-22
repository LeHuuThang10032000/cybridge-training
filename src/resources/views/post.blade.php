@extends('layouts.app')
@extends('layouts.navbar')

@section('title') {{$post->title}} @endsection

@section('content')

<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <div class="d-flex align-items-center flex-column">
        <div class="mb-3">
            @if($post->thumbnail !== null)
            <img src="{{ $post->thumbnail->getUrl() }}" alt="" width="100%" height="100%">
            @endif
        </div>

        <div class="mb-5">
            <p class="h1">{{ $post->title }}</p>
        </div>
    </div>

    {!! $post->content !!}
    
    <div class="d-flex justify-content-between">
        <address class="author">By {{ $post->author->name }}</address> <span>on <time pubdate datetime="{{ $post->created_at }}" title="{{ $post->created_at }}">"{{ $post->created_at }}"</time></span>
    </div>

    <div class="mb-2">
        <form class="like-post mb-0" action="" method="POST">
            @csrf
            <input type="hidden" value="{{ $post->id }}" name="post_id">
            <button id="like_{{$post->id}}" type="submit" href="{{$post->url}}" class="btn {{ ($post->liked()) ? 'btn-danger' : 'btn-outline-danger' }} p-1" style="border-radius: 50%">
                <img src="{{ asset('img/white-heart.png') }}" alt="#">
            </button>
            <span id="likes_count_{{$post->id}}">{{ $post->likeCount }} like(s)</span>
        </form>
    </div>
</div>

@can('create_comment')
<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <p class="">Write a comment:</p>
    <form class="mb-0" action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" value="{{ $post->id }}" name="post_id">
        <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content"></textarea>
        @if($errors->has('content'))
        <div class="text-danger">{{ $errors->first('content') }}</div>
        @endif
        <button type="submit" class="btn btn-primary mt-1">Submit</button>
    </form>
</div>
@endcan

<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <p>Comments:</p>
    @include('comments', ['comments' => $post->comments, 'post_id' => $post->id])
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
                                xhr.open('POST', "{{ route('posts.media.upload', ['_token' => csrf_token() ]) }}", true);
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
<script>
    $('.like-post').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var buttonId = '#like_' + formData.get('post_id');
        var countId = '#likes_count_' + formData.get('post_id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: "{{ route('posts.like') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.is_like == true) {
                    alert('liked');
                    $(buttonId).removeClass('btn-outline-danger').addClass('btn-danger');
                    $(countId).text(data.counts + ' like(s)');
                } else {
                    alert('unliked');
                    $(buttonId).removeClass('btn-danger').addClass('btn-outline-danger');
                    $(countId).text(data.counts + ' like(s)');
                }
            },
            error: function(xhr, status, error) {
                alert('Something went wrong');
            }
        });
    });
</script>
@endpush
@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Posts')

@section('content')

<div class="mx-auto" style="padding: 5px; width: 50%">
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
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
            <label for="exampleInputEmail1" class="form-label">Url</label>
            <input type="text" class="form-control" name="url" value="{{old('url', $post->url)}}">
            @if($errors->has('url'))
            <div class="text-danger">{{ $errors->first('url') }}</div>
            @endif
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Content</label>
            <textarea id="content" class="ckeditor form-control" name="content">{{old('content', $post->content)}}</textarea>
            @if($errors->has('content'))
            <div class="text-danger">{{ $errors->first('content') }}</div>
            @endif
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Thumbnail</label>
            <input type="text" class="form-control" name="thumbnail" value="{{old('thumbnail', $post->thumbnail)}}">
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
    CKEDITOR.replace('content', {
        filebrowserUploadUrl: "{{route('admin.posts.media.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endpush
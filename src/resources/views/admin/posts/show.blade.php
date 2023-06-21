@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Posts')

@section('content')

<div class="mx-auto" style="padding: 5px; width: 50%">
    <div class="mb-3">
        <p class="h5">Title: {{ $post->title }}</p>
    </div>
    <div class="mb-3">
        <p>Url: {{ $post->url }}</p>
    </div>
    <div class="mb-3">
        <div class="m-1">
            <p>Content:</p>
            {!! $post->content !!}
        </div>
    </div>
    <div class="mb-3">
        <p>Thumbnail: {{ $post->thumbnail }}</p>
    </div>
    <div class="mb-3">
        <p class="h5">Author: {{ $post->author->name }}</p>
    </div>
</div>

@endsection
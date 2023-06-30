@extends('layouts.app')
@extends('layouts.navbar')

@section('title', 'Profile')

@section('content')

<div class="d-flex">
    <div class="container m-2 border">
        <div class="card-header">
            <p class="h5">My comments</p>
        </div>
        <hr class="m-2">
        @foreach($comments as $comment)
        <div class="bg-light p-2 border mb-2">
            <strong>Your comment at <a href="{{$comment->post->url}}">{{$comment->post->title}}</a></strong>
            @if($comment->deleted_at !== null)
            <p>This comment has been remove</p>
            @else
            {!! $comment->content !!}
            @endif
        </div>
        @endforeach

        <div class="card-header">
            <p class="h5">People liked my posts</p>
        </div>
        <hr class="m-2">
        @foreach($likes as $like)
        <div class="bg-light p-2 border mb-2 d-flex justify-content-between">
            <p>{{ $like->user_name }} liked your post. <span class="fw-lighter">{{ now()->diffInMinutes($like->created_at) }}m</span></p>
            <a href="{{$like->post_url}}">
                <img src="{{$like->post_thumbnail}}" alt="" width="100px" height="100px">
            </a>
        </div>
        @endforeach
    </div>

    <div class="container m-2 border flex-grow-1">
        <div class="card-header">
            <p class="h5">My posts</p>
        </div>
        <hr class="m-2">
        @foreach($posts as $post)
        <div class="bg-light p-2 border mb-2 d-flex justify-content-between">
            <div class="d-flex flex-column">
                <p>{{ $post->title }} </p>
                <p><span class="fw-lighter">Published on: {{ $post->created_at }}</span></p>
                <p class="mb-0"><span><img src="{{ asset('img/heart.png') }}" alt=""></span> {{ $post->likeCount }}</p>
            </div>
            <a href="{{ $post->url }}">
                <img src="{{ $post->thumbnail->getUrl() }}" alt="" width="100px" height="100px">
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection
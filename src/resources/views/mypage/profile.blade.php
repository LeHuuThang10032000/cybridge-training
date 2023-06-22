@extends('layouts.app')
@extends('layouts.navbar')

@section('title', 'Profile')

@section('content')

<div class="d-flex w-100">
    <div class="container m-2 border">
        <div class="card-header">
            your comments
        </div>
        <hr>
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
    </div>

    <div class="container m-2 border">
        <div class="card-header">
            People liked your post
        </div>
        <hr>
        @foreach($myPosts as $post)
        <div class="bg-light p-2 border mb-2">
            <p>{{ $post->user_name }} liked your post. <span class="fw-lighter">{{ now()->diffInMinutes($post->created_at) }}m</span></p>
            <a href="">
                <img src="" alt="" width="20px" height="20px">
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection
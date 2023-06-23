@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Medias')

@section('content')

<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <div class="box">Posts Media</div>
    <table class="table">
        <thead style="background-color: #08C;">
            <tr>
                <th scope="col" class="text-white">post id</th>
                <th scope="col" class="text-white">image</th>
                <th scope="col" class="text-white">type</th>
                <th scope="col" class="text-white">actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            @foreach($post->getMedia("ck-media") as $media)
            <tr>
                <th scope="row">{{$post->id}}</th>
                <td>
                    <img src="{{ $media->getUrl() }}" alt="" width="150px" height="150px">
                </td>
                <td scope="row">{{$media->collection_name}}</td>
                <td>
                    <a class="btn btn-link mx-1" href="{{ route('admin.medias.edit', $media->id) }}">Edit</a>
                    <form class="mb-0" method="POST" action="{{ route('admin.medias.destroy', $media->id) }}" onSubmit="return confirm('Are you want to delete this media?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if($post->thumbnail)
            <tr>
                <th scope="row">{{$post->thumbnail->id}}</th>
                <td>
                    <img src="{{ $post->thumbnail->getUrl() }}" alt="" width="150px" height="150px">
                </td>
                <td scope="row">{{$post->thumbnail->collection_name}}</td>
                <td>
                    <a class="btn btn-link mx-1" href="{{ route('admin.medias.edit', $post->thumbnail->id) }}">Edit</a>
                    <form class="mb-0" method="POST" action="{{ route('admin.medias.destroy', $post->thumbnail->id) }}" onSubmit="return confirm('Are you want to delete this media?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

<div class="mx-auto my-2 border" style="padding: 5px; width: 50%">
    <div class="box">Comments Media</div>
    <table class="table">
        <thead style="background-color: #08C;">
            <tr>
                <th scope="col" class="text-white">comment id</th>
                <th scope="col" class="text-white">user</th>
                <th scope="col" class="text-white">image</th>
                <th scope="col" class="text-white">actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
            @foreach($comment->getMedia("ck-media") as $media)
            <tr>
                <th scope="row">{{$comment->id}}</th>
                <th scope="row">{{$comment->user->name}}</th>
                <td>
                    <img src="{{ $media->getUrl() }}" alt="" width="150px" height="150px">
                </td>
                <td>
                    <a class="btn btn-link mx-1" href="{{ route('admin.posts.show', $comment->post->id) }}#section-{{ $comment->id }}">Edit</a>
                    <form class="mb-0" method="POST" action="{{ route('admin.medias.destroy', $media->id) }}" onSubmit="return confirm('Are you want to delete this media?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>

@endsection
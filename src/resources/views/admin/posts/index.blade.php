@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Posts')

@section('content')

<div class="mx-auto" style="padding: 5px; width: fit-content; max-width: 80%">
    <div class="my-2">
        <a class="btn btn-primary" href="{{ route('admin.posts.create') }}">Create</a>
    </div>
    <table class="table">
        <thead style="background-color: #08C;">
            <tr>
                <th scope="col">id</th>
                <th scope="col">title</th>
                <th scope="col">url</th>
                <th scope="col">thumbnail</th>
                <th scope="col">author</th>
                <th scope="col">created at</th>
                <th scope="col">updated at</th>
                <th scope="col">actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <th scope="row">{{$post->id}}</th>
                <td>{{$post->title}}</td>
                <td>{{$post->url}}</td>
                <td>{{$post->thumbnail}}</td>
                <td>{{$post->author->name}}</td>
                <td>{{$post->created_at}}</td>
                <td>{{$post->created_at}}</td>
                <td>
                    <div class="d-flex">
                        <a class="btn btn-link mx-1" href="{{ route('admin.posts.show', $post->id) }}">Show</a>
                        <a class="btn btn-link mx-1" href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>
                        <form class="mb-0" method="POST" action="{{ route('admin.posts.destroy', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
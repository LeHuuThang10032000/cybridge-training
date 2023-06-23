@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Posts')

@section('content')

<div class="mx-auto" style="padding: 5px; width: fit-content; max-width: 80%">
    <div class="my-2">
        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Export
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.posts.export', ['type' => 'xlsx']) }}">xlsx</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.posts.export', ['type' => 'csv']) }}">csv</a></li>
        </ul>
        <a class="btn btn-primary" href="{{ route('admin.posts.create') }}">Create</a>
    </div>
    <table class="table align-middle">
        <thead style="background-color: #08C;">
            <tr>
                <th scope="col" class="text-white">id</th>
                <th scope="col" class="text-white">thumbnail</th>
                <th scope="col" class="text-white">title</th>
                <th scope="col" class="text-white">url</th>
                <th scope="col" class="text-white">author</th>
                <th scope="col" class="text-white">created at</th>
                <th scope="col" class="text-white">updated at</th>
                <th scope="col" class="text-white">actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <th scope="row">{{$post->id}}</th>
                <td>
                    @if($post->thumbnail !== null)
                    <img src="{{ $post->thumbnail->getUrl() }}" alt="" width="150px" height="150px">
                    @endif
                </td>
                <td>{{$post->title}}</td>
                <td>
                    <a href="{{$post->url}}">{{$post->url}}</a>
                </td>
                <td>{{$post->author->name}}</td>
                <td>{{$post->created_at}}</td>
                <td>{{$post->created_at}}</td>
                <td>
                    <div class="d-flex">
                        <a class="btn btn-link mx-1" href="{{ route('admin.posts.show', $post->id) }}">Show</a>
                        <a class="btn btn-link mx-1" href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>
                        <form class="mb-0" method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" onSubmit="return confirm('Are you want to delete this post?');">
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
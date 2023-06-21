<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return  view('admin.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'url' => $request->url,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
            'creator_model' => Auth::user()->getTable(),
            'created_by_id' => Auth::user()->id,
        ]);

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $post->id]);
        }

        return back();
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'url' => $request->url,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
            'creator_model' => Auth::user()->getTable(),
            'created_by_id' => Auth::user()->id,
        ]);

        return back();
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('admin/posts');
    }

    public function storeCKImage(Request $request)
    {
        $model         = new Post();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

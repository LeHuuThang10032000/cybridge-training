<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PostsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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
        $post->with('comments', 'comments.user', 'comments.replies');
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
            'url' => '',
            'content' => $request->content,
            'thumbnail' => '',
            'creator_model' => Auth::user()->getTable(),
            'created_by_id' => Auth::user()->id,
        ]);

        if($post) {
            $post->url = url('/posts/' . $post->id);
            $post->save();
        }

        if($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()){
            $post->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $post->id]);
        }

        return back();
    }

    public function edit(Post $post)
    {
        $post->with('comments', 'comments.user');
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'url' => url('/posts/' . $post->id),
            'content' => $request->content,
            'thumbnail' => '',
            'creator_model' => Auth::user()->getTable(),
            'created_by_id' => Auth::user()->id,
        ]);

        if ($request->hasFile('thumbnail', false)) {
            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
                if ($post->thumbnail) {
                    $post->thumbnail->delete();
                }
                $post->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
            }
        }
        
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $post->id]);
        }

        return back();
    }

    public function destroy(Post $post)
    {
        $post->thumbnail->delete();
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

    public function export(Request $request)
    {
        return Excel::download(new PostsExport, 'posts.' . $request->type);
    }
}

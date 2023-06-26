<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PostsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\Post\PostRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostController extends Controller
{
    protected $postRepo;
    protected $permissionRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        $page = request()->has('page') ? request()->get('page') : 1;

        $posts = $this->postRepo->getPosts(10, ['media', 'likeCounter', 'admin', 'author']);

        return view('admin.posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post = $this->postRepo->findWith($id, ['comments', 'comments.user', 'comments.replies']);

        return view('admin.posts.show', compact('post'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $post = $this->postRepo->create([
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

    public function edit($id)
    {
        $post = $this->postRepo->findWith($id, ['comments', 'comments.user']);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->postRepo->update($post->id, [
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
        if($post->thumbnail) {
            $post->thumbnail->delete();
        }
        $this->postRepo->delete($post->id);

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
        try {
            (new PostsExport)->queue('posts.'. $request->type, 'export');

            return back()->with('message', 'Export successfully completed');
        } catch(Exception $e) {
            return back()->with('message', $e);
        }
    }
}

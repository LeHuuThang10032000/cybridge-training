<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Repositories\Post\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostController extends Controller
{
    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function detail($id)
    {
        $post = $this->postRepo->findWith($id);

        return view('post', compact('post'));
    }

    public function like(Request $request)
    {
        $post = $this->postRepo->find($request->post_id);

        if ($post->liked(Auth::user()->id)) {
            $post->unlike();
            $post->save();
        } else {
            $post->like();
            $post->save();
        }

        return response()->json(['is_like' => $post->liked(), 'counts' => $post->likeCount]);
    }

    public function create()
    {
        abort_if(Gate::denies('create_post'), 403);

        return view('mypage.post');
    }

    public function store(StorePostRequest $request)
    {
        abort_if(Gate::denies('create_post'), 403);

        $post = $this->postRepo->create([
            'title' => $request->title,
            'url' => '',
            'content' => $request->content,
            'thumbnail' => '',
            'creator_model' => Auth::guard('web')->user()->getTable(),
            'created_by_id' => Auth::user()->id,
        ]);

        if ($post) {
            $post->url = url('/posts/' . $post->id);
            $post->save();
        }

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $post->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $post->id]);
        }

        return back();
    }

    public function storeCKImage(Request $request)
    {
        abort_if(Gate::denies('create_comment'), 403);

        $model         = new Post();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

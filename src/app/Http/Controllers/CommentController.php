<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(CommentRepository $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }
    
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_comment'), 403);

        $comment = $this->commentRepo->create([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_id'  => Auth::user()->id,
            'user_model' => Auth::user()->getTable(),
            'parent_id' => $request->parent_id ?? null,
        ]);

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $comment->id]);
        }
        return back();
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        abort_if(Gate::denies('create_comment'), 403);

        $comment->update([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_model' => Auth::user()->getTable(),
        ]);

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $comment->id]);
        }
        return back();
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back();
    }
}

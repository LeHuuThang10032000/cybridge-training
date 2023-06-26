<?php
namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel()
    {
        return Comment::class;
    }

    public function getUserComment($id)
    {
        return $this->model->where('user_model', 'users')->where('user_id', $id)->with('post')->get();
    }

    public function getWith(array $relations = null)
    {
        return $this->model->with($relations)->get();
    }

    public function findWith($id, array $relations = null)
    {
        return $this->model->where('id', $id)
            ->with($relations)
            ->with('media', 'likeCounter', 'comments', 'comments.user', 'comments.replies')
            ->first();
    }
}

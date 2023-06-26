<?php
namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function getModel()
    {
        return Post::class;
    }

    public function getPosts($paginate = null, array $relations = null)
    {
        if(isset($paginate)) return $this->model->with($relations)->simplePaginate($paginate); 
        return $this->model->with($relations)->get();
    }

    public function findWith($id, array $relations = null)
    {
        return $this->model->where('id', $id)
            ->with($relations)
            ->first();
    }

    public function getWithUserId($id)
    {
        return $this->model->where('creator_model', 'users')
            ->where('created_by_id', $id)
            ->with('media', 'likeCounter', 'comments', 'comments.user', 'comments.replies')
            ->first();
    }

    public function getPeopleLikedMyPosts($id)
    {
        return DB::table('likeable_likes')
            ->select('*',
                DB::raw('(select name from users where `users`.`id` = `likeable_likes`.`user_id`) as user_name'),
                DB::raw('(select title from posts where `posts`.`id` = `likeable_likes`.`likeable_id`) as post_title'))
            ->where('user_id', '!=', $id)
            ->get();
    }

    public function getLikedPosts($id)
    {
        return $this->model->whereLikedBy($id)->with('media', 'likeCounter')->get();
    }
}

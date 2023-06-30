<?php
namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
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

    public function getPeopleLikedMyPosts($id, $posts)
    {
        $ids = $posts->pluck('id');

        $url = config('app.url');

        return DB::table('likeable_likes')
                ->select('*',
                    DB::raw('(select name from users where `users`.`id` = `likeable_likes`.`user_id`) as user_name'),
                    DB::raw('(select url from posts where `posts`.`id` = `likeable_likes`.`likeable_id`) as post_url'),
                    DB::raw('(select CONCAT("'. $url .'", "/storage/", `media`.`id`, "/", `media`.`file_name`) from media where `media`.`model_id` = `likeable_likes`.`likeable_id` AND `media`.`collection_name` = "thumbnail" LIMIT 1) as post_thumbnail'))
                ->where('user_id', '!=', $id)
                ->whereIn('likeable_id', $ids)
                ->get();
    }

    public function getLikedPosts($id)
    {
        return $this->model->whereLikedBy($id)->with('media', 'likeCounter')->get();
    }

    public function getUserPosts()
    {
        return $this->model->where('creator_model', 'users')->where('created_by_id', Auth::user()->id)->get();
    }
}

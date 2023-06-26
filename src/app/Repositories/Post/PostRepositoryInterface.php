<?php
namespace App\Repositories\Post;

use App\Repositories\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function getPosts();

    public function findWith($id, array $relations = null);

    public function getWithUserId($id);

    public function getPeopleLikedMyPosts($id);

    public function getLikedPosts($id);
}

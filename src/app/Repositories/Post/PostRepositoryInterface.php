<?php
namespace App\Repositories\Post;

use App\Repositories\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function getPosts();

    public function findWith($id, array $relations = null);

    public function getPeopleLikedMyPosts($id, $posts);

    public function getLikedPosts($id);

    public function getUserPosts();
}

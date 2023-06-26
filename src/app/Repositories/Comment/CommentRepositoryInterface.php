<?php
namespace App\Repositories\Comment;

use App\Repositories\RepositoryInterface;

interface CommentRepositoryInterface extends RepositoryInterface
{
    public function getUserComment($id);

    public function getWith(array $relations = null);

    public function findWith($id, array $relations = null);
}

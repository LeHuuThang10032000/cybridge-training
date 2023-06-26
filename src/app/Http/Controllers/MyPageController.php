<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Post\PostRepository;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    protected $postRepo;
    protected $commentRepo;

    public function __construct(PostRepository $postRepo, CommentRepository $commentRepo)
    {
        $this->postRepo = $postRepo;
        $this->commentRepo = $commentRepo;
    }

    public function like()
    {
        $posts = $this->postRepo->getLikedPosts(Auth::user()->id);

        return view('mypage.liked', compact('posts'));
    }

    public function profile()
    {
        $comments = $this->commentRepo->getUserComment(Auth::user()->id);

        $myPosts = $this->postRepo->getPeopleLikedMyPosts(Auth::user()->id);
        
        return view('mypage.profile', compact('comments', 'myPosts'));
    }
}

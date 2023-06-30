<?php

namespace App\Http\Controllers;

use App\Repositories\Comment\CommentRepository;
use App\Repositories\Post\PostRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MyPageController extends Controller
{
    protected $postRepo;
    protected $commentRepo;

    public function __construct(PostRepository $postRepo, CommentRepository $commentRepo)
    {
        $this->postRepo = $postRepo;
        $this->commentRepo = $commentRepo;
    }

    public function like(): View
    {
        try {
            $posts = $this->postRepo->getLikedPosts(Auth::user()->id);

            return view('mypage.liked', compact('posts'));
        } catch(Exception $e) {
            Log::channel('mypagelog')->info('Failed to load liked posts: {e}', ['e' => $e]);
            return abort(404);
        }
    }

    public function profile()
    {
            $comments = $this->commentRepo->getUserComment(Auth::user()->id);

            $posts = $this->postRepo->getUserPosts();

            $likes = $this->postRepo->getPeopleLikedMyPosts(Auth::user()->id, $posts);
            
            return view('mypage.profile', compact('comments', 'likes', 'posts'));
    }
}

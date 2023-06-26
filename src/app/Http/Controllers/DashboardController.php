<?php

namespace App\Http\Controllers;

use App\Repositories\Post\PostRepository;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        $posts = $this->postRepo->getPosts(null, ['media', 'likeCounter']);
        
        return view('dashboard', compact('posts'));
    }
}

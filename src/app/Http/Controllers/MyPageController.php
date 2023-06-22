<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyPageController extends Controller
{
    public function like()
    {
        $posts = Post::where('creator_model', 'users')->whereLikedBy(Auth::user()->id)->with('media', 'likeCounter')->get();

        return view('mypage.liked', compact('posts'));
    }

    public function profile()
    {
        $comments = Comment::where('user_model', 'users')->where('user_id', Auth::user()->id)->with('post')->get();

        $myPosts = DB::table('likeable_likes')
            ->select('*',
                DB::raw('(select name from users where `users`.`id` = `likeable_likes`.`user_id`) as user_name'),
                DB::raw('(select title from posts where `posts`.`id` = `likeable_likes`.`likeable_id`) as post_title'))
            ->where('user_id', '!=', Auth::user()->id)
            ->get();
        return view('mypage.profile', compact('comments', 'myPosts'));
    }
}

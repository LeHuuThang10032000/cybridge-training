<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function created(Post $post): void
    {
        Cache::tags('posts')->flush();
    }

    public function updated(Post $post): void
    {
        Cache::tags('posts')->flush();
    }

    public function deleted(Post $post): void
    {
        Cache::tags('posts')->flush();
    }

    public function restored(Post $post): void
    {
        //
    }

    public function forceDeleted(Post $post): void
    {
        //
    }
}

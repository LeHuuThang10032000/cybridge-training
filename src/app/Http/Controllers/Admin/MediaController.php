<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function index()
    {
        $posts = Post::with('media')->get();

        return view('admin.medias.index', compact('posts'));
    }

    

    public function destroy(Media $media)
    {
        $media->delete();

        return redirect('admin/medias');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Post\PostRepository;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    protected $postRepo;
    protected $commentRepo;

    public function __construct(PostRepository $postRepo, CommentRepository $commentRepo)
    {
        $this->postRepo = $postRepo;
        $this->commentRepo = $commentRepo;
    }

    public function index()
    {
        $posts = $this->postRepo->getPosts(null, ['media']);
        $comments = $this->commentRepo->getWith(['media']);

        return view('admin.medias.index', compact('posts', 'comments'));
    }

    

    public function destroy(Media $media)
    {
        $media->delete();

        return redirect('admin/medias');
    }
}

<?php

namespace App\Models;

use Conner\Likeable\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia, Likeable, SoftDeletes;

    protected $appends = ['author_name'];
    
    protected $fillable = [
        'title',
        'url',
        'content',
        'thumbnail',
        'creator_model',
        'created_by_id',
    ];

    public function author()
    {
        if($this->creator_model == 'admins') {
            return $this->belongsTo(Admin::class, 'created_by_id', 'id');
        }
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('parent_id', null)->withTrashed();;
    }

    public function getThumbnailAttribute()
    {
        return $this->getMedia('thumbnail')->last();
    }

    public function getAuthorNameAttribute()
    {
        return $this->author->name;
    }
}

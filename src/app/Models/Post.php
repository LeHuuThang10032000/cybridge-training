<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
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
}

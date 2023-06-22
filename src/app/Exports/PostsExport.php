<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostsExport implements FromCollection
{
    public function headings(): array
    {
        return [
            '#',
            'title',
            'url',
            'content',
            'author',
        ];
    }

    public function collection()
    {
        return Post::select('id', 'title', 'url', 'content', 'author_name')->get();
    }
}

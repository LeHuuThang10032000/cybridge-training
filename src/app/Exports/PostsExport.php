<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PostsExport implements FromCollection, WithHeadings, WithDrawings
{
    public function headings(): array
    {
        return [
            '#',
            'title',
            'url',
            'content',
            'thumbnail',
            'auhtor id',
            'author role',
            'author name',
        ];
    }

    public function collection()
    {
        $posts = Post::all();

        $postsMap = $posts->map(function($post) {
            $post->author_name = $post->author->name;
            unset($post->author);
            unset($post->thumbnail);
            return $post;
        });

        return $postsMap;
    }

    public function drawings()
    {
        $data = Post::all();
        $drawings = [];
        foreach ($data as $key => $post) {
            $drawing = new Drawing();
            $drawing->setPath(storage_path('app/public/' . $post->thumbnail->id . '/' . $post->thumbnail->file_name));
            $drawing->setHeight(50);
            $drawing->setWidth(120);
            $drawing->setCoordinates('E' . ($key + 2));
            $drawings[] = ($drawing);
        }
        return $drawings;
    }

}

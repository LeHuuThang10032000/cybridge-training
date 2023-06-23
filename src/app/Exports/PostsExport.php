<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
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
            'author'
        ];
    }

    public function collection()
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $post->author = $post->author->name;
            unset($post->author);
        }

        return $posts;
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

    public function columnWidths(): array
    {
        return [
            'E' => 120,
        ];
    }
}

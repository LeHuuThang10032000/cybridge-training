<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            '#',
            'name',
            'email',
        ];
    }

    public function collection()
    {
        return User::select('id', 'name', 'email')->get();
    }
}

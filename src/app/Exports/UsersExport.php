<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings, ShouldQueue
{
    use Exportable;

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

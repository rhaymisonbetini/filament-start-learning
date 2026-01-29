<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentExport implements FromCollection, WithMapping, WithHeadings
{

    use Exportable;

    public function __construct(public Collection $students)
    {
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->students;
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'class',
            'section',
            'created at'
        ];
    }

    /**
     * @param $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->name,
            $row->email,
            $row->classes->name,
            $row->section->name,
            $row->created_at->format('d-m-Y'),
        ];
    }
}

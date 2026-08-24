<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionsTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([
            [
                'Umum',
                'Apa ibukota Indonesia?',
                'Jakarta'
            ],
            [
                'Sains',
                'Air mendidih pada suhu berapa derajat celcius?',
                '100'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Kategori (Opsional)',
            'Pertanyaan (Wajib)',
            'Jawaban (Wajib)'
        ];
    }
}

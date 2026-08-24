<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class QuestionsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip baris jika kolom pertanyaan (index 1) kosong
        if (!isset($row[1]) || trim($row[1]) === '') {
            return null;
        }

        return new Question([
            'category'      => $row[0] ?? null,
            'question_text' => $row[1],
            'answer_text'   => $row[2] ?? '',
            'is_used'       => false,
        ]);
    }

    /**
     * Start reading from row 2 to skip the header
     */
    public function startRow(): int
    {
        return 2;
    }
}

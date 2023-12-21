<?php

namespace App\imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeammembersSalaryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return $row;
    }
}

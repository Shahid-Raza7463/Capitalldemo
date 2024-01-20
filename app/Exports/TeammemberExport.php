<?php

namespace App\Exports;

use App\Teammember; // Adjust the namespace based on your model

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeammemberExport implements FromCollection, WithHeadings
{
    protected $teammemberOnlySave;

    public function __construct($teammemberOnlySave)
    {
        $this->teammemberOnlySave = $teammemberOnlySave;
    }

    public function collection()
    {
        return $this->teammemberOnlySave;
    }

    public function headings(): array
    {
        // Customize the headings based on your data structure
        return [
            'Name',
            'Email ID',
        ];
    }
}

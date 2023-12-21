<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimesheetLastWeekExport implements FromCollection, WithHeadings
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
            'Last Submission Date',
        ];
    }
}

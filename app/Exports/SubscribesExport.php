<?php

namespace App\Exports;

use App\Models\Subscribe;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscribesExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    private $selectedRows;

    public function __construct($selectedRows)
    {
        $this->selectedRows = $selectedRows;
    }

    public function map($subscribe) : array
    {
        return [
            $subscribe->id,
            $subscribe->email
        ];
    }

    public function headings() : array
    {
        return [
            '#ID',
            'Email'
        ];
    }

    public function query()
    {
        return Subscribe::with(['updatedBy'])->whereIn('status', $this->selectedRows);
    }
}

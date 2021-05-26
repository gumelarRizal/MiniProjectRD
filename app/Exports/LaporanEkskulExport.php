<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanEkskulExport implements FromArray, WithHeadings
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    // public function collection()
    // {
    //     return $this->data;
    // }

    public function array(): array
    {
        return 
            $this->data
        ;
    }

    public function headings(): array
    {
        return [
            'Ekskul',
            'Jumlah',
        ];
    }
}

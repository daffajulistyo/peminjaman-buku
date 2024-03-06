<?php
// app/Exports/AbsensiExport.php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected $absensi;

    public function __construct($absensi)
    {
        $this->absensi = $absensi;
    }
    
    public function collection()
    {
        return Absensi::select('name', 'tanggal', 'jam_masuk', 'jam_keluar')->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Tanggal',
            'Jam Masuk',
            'Jam keluar',
        ];
    }
}

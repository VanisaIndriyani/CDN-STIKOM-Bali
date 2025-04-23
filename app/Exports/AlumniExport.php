<?php

namespace App\Exports;

use App\Models\Alumni;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AlumniExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Alumni::all();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIM',
            'Tahun Lulus',
            'Jenis Kelamin',
            'Pekerjaan',
            'Perusahaan',
            'Bidang Pekerjaan',
            'Relevansi',
            'Gaji',
            'Waktu Tunggu',
            'Status Pekerjaan'
        ];
    }

    public function map($alumni): array
    {
        return [
            $alumni->name,
            $alumni->nim,
            $alumni->graduation_year,
            $alumni->gender,
            $alumni->current_job,
            $alumni->company,
            $alumni->job_field,
            $alumni->job_relevance,
            $alumni->salary,
            $alumni->waiting_time,
            $alumni->employment_status
        ];
    }
}
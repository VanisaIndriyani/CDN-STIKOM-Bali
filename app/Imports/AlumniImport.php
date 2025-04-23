<?php

namespace App\Imports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Alumni([
            'nama' => $row['nama'],
            'nim' => $row['nim'],
            'tahun_lulus' => (int)$row['tahun_lulus'],
            'periode_wisuda' => $row['periode_wisuda'],
            'tahun_yudisium' => (int)$row['tahun_yudisium'],
            'pekerjaan' => $row['pekerjaan'] ?? null,
            'perusahaan' => $row['perusahaan'] ?? null,
            'bidang' => $row['bidang'] ?? null,
            'relevansi' => $row['relevansi'] ?? false,
        ]);
    }
}
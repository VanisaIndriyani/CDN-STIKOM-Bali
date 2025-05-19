<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nim', 'LIKE', "%{$search}%")
                  ->orWhere('pekerjaan', 'LIKE', "%{$search}%")
                  ->orWhere('perusahaan', 'LIKE', "%{$search}%")
                  ->orWhere('bidang', 'LIKE', "%{$search}%");
            });
        }

        $alumni = $query->paginate(10);

        return view('admin.alumni.index', compact('alumni'));
    }

    public function create()
    {
        return view('admin.alumni.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:alumni,nim',
            'tahun_lulus' => 'required|numeric',
            'tahun_yudisium' => 'required|numeric',
            'periode_wisuda' => 'required',
            'pekerjaan' => 'nullable',
            'perusahaan' => 'nullable',
            'bidang' => 'nullable',
            'rata_rata_gaji' => 'nullable|numeric|min:0',
            'relevansi' => 'nullable|boolean'
        ]);

        Alumni::create($validated);

        return redirect()->route('admin.alumni.index')
                         ->with('success', 'Data alumni berhasil ditambahkan');
    }

    public function edit(Alumni $alumni)
    {
        return view('admin.alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $alumni->update([
            'relevansi' => $request->relevansi
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();

        return response()->json(['success' => true]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        DB::beginTransaction();

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove header row
            array_shift($rows);

            $imported = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                try {
                    if (!empty($row[0]) && !empty($row[1])) {
                        Alumni::create([
                            'nama' => $row[0],
                            'nim' => $row[1],
                            'tahun_lulus' => (int)$row[2],
                            'periode_wisuda' => $row[3],
                            'tahun_yudisium' => (int)$row[4],
                            'pekerjaan' => $row[5] ?? null,
                            'perusahaan' => $row[6] ?? null,
                            'bidang' => $row[7] ?? null,
                            'rata_rata_gaji' => !empty($row[8]) ? (float)$row[8] : null,
                            'relevansi' => $this->parseBoolean($row[9] ?? '')
                        ]);
                        $imported++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            if (count($errors) > 0) {
                DB::rollBack();
                Log::error('Import errors: ', $errors);
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . implode(', ', $errors));
            }

            DB::commit();

            return redirect()->route('admin.alumni.index')
                             ->with('success', "Berhasil mengimpor $imported data alumni");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    private function parseBoolean($value): bool
    {
        $value = strtolower(trim($value));
        return in_array($value, ['true', '1', 'yes'], true);
    }

    public function export()
    {
        $alumni = Alumni::all();
        $filename = 'alumni_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        fputcsv($output, ['Nama', 'NIM', 'Tahun Lulus', 'Tahun Yudisium', 'Periode Wisuda', 'Pekerjaan', 'Perusahaan', 'Bidang', 'Relevansi']);

        foreach ($alumni as $alum) {
            fputcsv($output, [
                $alum->nama,
                $alum->nim,
                $alum->tahun_lulus,
                $alum->tahun_yudisium,
                $alum->periode_wisuda,
                $alum->pekerjaan,
                $alum->perusahaan,
                $alum->bidang,
                $alum->relevansi
            ]);
        }

        fclose($output);
        exit;
    }

    public function template()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Nama', 'NIM', 'Tahun Lulus', 'Periode Wisuda', 'Tahun Yudisium', 'Pekerjaan', 'Perusahaan', 'Bidang', 'Rata-rata Gaji', 'Relevansi'];
        $sheet->fromArray([$headers], null, 'A1');

        $sampleData = [
            ['John Doe', '12345', '2023', 'Periode 1', '2023', 'Programmer', 'Tech Corp', 'IT', '5000000', 'TRUE']
        ];
        $sheet->fromArray($sampleData, null, 'A2');

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template_alumni.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function generateRandomExcel()
    {
        try {
            // Get 5 random alumni records
            $randomAlumni = Alumni::inRandomOrder()->limit(5)->get();
            
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set headers
            $headers = ['Nama', 'NIM', 'Tahun Lulus', 'Periode Wisuda', 'Tahun Yudisium', 
                       'Pekerjaan', 'Perusahaan', 'Bidang', 'Rata-rata Gaji', 'Relevansi'];
            $sheet->fromArray([$headers], NULL, 'A1');
            
            // Add random data
            $row = 2;
            foreach ($randomAlumni as $alumni) {
                $sheet->setCellValue('A'.$row, $alumni->nama);
                $sheet->setCellValue('B'.$row, $alumni->nim);
                $sheet->setCellValue('C'.$row, $alumni->tahun_lulus);
                $sheet->setCellValue('D'.$row, $alumni->periode_wisuda);
                $sheet->setCellValue('E'.$row, $alumni->tahun_yudisium);
                $sheet->setCellValue('F'.$row, $alumni->pekerjaan);
                $sheet->setCellValue('G'.$row, $alumni->perusahaan);
                $sheet->setCellValue('H'.$row, $alumni->bidang);
                $sheet->setCellValue('I'.$row, $alumni->rata_rata_gaji);
                $sheet->setCellValue('J'.$row, $alumni->relevansi ? 'Ya' : 'Tidak');
                $row++;
            }
            
            // Auto-size columns
            foreach (range('A', 'J') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Create Excel file
            $writer = new Xlsx($spreadsheet);
            $filename = 'contoh_data_alumni_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate file: ' . $e->getMessage());
        }
    }

    public function showImportForm()
    {
        return view('admin.alumni.import');
    }
}
